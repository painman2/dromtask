var strshow = $(".selected").prop("innerHTML");
var cnttodos = +$(".view").length;
var cntcompleted = +$(".completed").length;
var cntactive = cnttodos - cntcompleted;

if(strshow == "All") $(".todo-list li").show();
else if(strshow == "Active"){
    $(".todo-list li").show();
    $(".completed").hide();
}else if(strshow == "Completed"){
    $(".todo-list li").hide();
    $(".completed").show();
} 

if(cntcompleted) $(".clear-completed").show();
else $(".clear-completed").hide();

if(cntcompleted && cntcompleted == cnttodos) $("#toggle-all").attr("checked","");

//AJAX create new todo
$(".new-todo").on("keypress", function(e){
    if (e.keyCode === 13) {
        var name = $(this).val();
        $.post("./", {cmd: 'addtodo', name: name}, function(res){
            if(res.answer == "OK"){
                var strhidden = '';
                if(strshow == "Completed") strhidden = ' style="display: none;"';
                var appendstr = '<li> \
            						<div class="view"'+strhidden+'> \
            							<input class="toggle" type="checkbox" > \
            							<label>'+name+'</label> \
            							<button class="destroy"></button> \
            						</div> \
            						<input class="edit" value="'+name+'"> \
                                    <input type="hidden" value="'+res.id+'"> \
            					</li>';
                
                $(".todo-list").append(appendstr);
                cnttodos++;
                cntactive++;
                $(".todo-count strong").prop("innerHTML", cntactive);
                $(".mainapp").show();
                $(".footer").show();
                $("#toggle-all").removeAttr("checked");      
            }else alert(res.answer);
        },"json");
        $(".new-todo").val('');
    }
    return true;
});

//Show input text for edit todo
$(".todo-list").on("dblclick", ".view", function(){
    $(this).next().show();
    $(this).parent().addClass("editing");
    $(this).next().focus().val($(this).next().val());
   
});

//AJAX edit todo
$(".todo-list").on("blur", ".edit", function(e){
    var name = $(this).val();
    var label = $('.editing label');
    var oldval = $(label).prop("innerHTML");
    if(name != '' && name != oldval){
        $(label).prop("innerHTML", name);
        var idtodo = $(this).next().val();
        $.post("./", {cmd: 'updatetodo', name: name, id: idtodo}, function(res){
            if(res.answer != "OK") alert(res.answer);
        },"json");
    }
    if(name == '') $(this).val(oldval);
    $(this).parent().removeClass("editing");
    $(this).hide();
    
});

//AJAX change state for all todos
$("#toggle-all").on("change", function(){
    var cmd = 'uncheckalltodos';
    if($(this).attr("checked")){
        cmd = 'checkalltodos';
        $(".toggle").attr("checked","");
        $(".toggle").parent().parent().addClass("completed");
        cntactive = 0;
        cntcompleted = cnttodos;
        $(".clear-completed").show();
    }else{
        cntcompleted = 0;
        $(".clear-completed").hide();
        cntactive = cnttodos;
        $(".toggle").removeAttr("checked");
        $(".toggle").parent().parent().removeClass("completed");
    } 
    $(".todo-count strong").prop("innerHTML", cntactive);
    $.post("./", {cmd: cmd}, function(res){
        if(res.answer != "OK") alert(res.answer);
    },"json");
});

//AJAX change state todo
$(".todo-list").on("change", ".toggle", function(){
    var cmd = 'unchecktodo';
    if($(this).attr("checked")){
        cmd = 'checktodo';
        $(this).attr("checked","");
        $(this).parent().parent().addClass("completed");
        cntactive--;
        cntcompleted++;
        $(".clear-completed").show();
        if(cntcompleted == cnttodos) $("#toggle-all").attr("checked","");
    }else{
        $(this).removeAttr("checked");
        $(this).parent().parent().removeClass("completed");
        if(cntcompleted == cnttodos) $("#toggle-all").removeAttr("checked");
        cntactive++;
        cntcompleted--;
        if(!cntcompleted) $(".clear-completed").hide();
    }

    $(".todo-count strong").prop("innerHTML", cntactive); 
    var idtodo = $(this).parent().next().next().val();
    $.post("./", {cmd: cmd, id: idtodo}, function(res){
        if(res.answer != "OK") alert(res.answer);
    },"json");
});

//AJAX remove todo
$(".todo-list").on("click", ".destroy", function(){
    var idtodo = $(this).parent().next().next().val();
    $.post("./", {cmd: 'removetodo', id: idtodo}, function(res){
        if(res.answer != "OK") alert(res.answer);
    },"json");
    if($(this).prev().prev().attr("checked")){
        if(cntcompleted == cnttodos) $("#toggle-all").removeAttr("checked");
        cntcompleted--;
    }else{
        cntactive--;
        $(".todo-count strong").prop("innerHTML", cntactive);
    }
    $(this).parent().parent().remove();
    cnttodos--;
    if(!cnttodos){
        $(".mainapp").hide();
        $(".footer").hide();
    }
});

//AJAX remove all completed todos
$(".clear-completed").on("click", function(){
    $.post("./", {cmd: 'rmcompletedtodos'}, function(res){
        if(res.answer != "OK") alert(res.answer);
    },"json");
    cntcompleted = +$(".completed").length;
    $(".completed").remove();
    cnttodos = cnttodos - cntcompleted;
    cntcompleted = 0;
    if(!cnttodos){
        $(".mainapp").hide();
        $(".footer").hide();
    }
    $(this).hide();
});

//AJAX set filter show todos
$(".filters").on("click", "a", function(event){
    strshow = $(this).prop("innerHTML");
    $.post("./", {cmd: 'setfilter', show: strshow}, function(res){
        if(res.answer != "OK") alert(res.answer);
    },"json");
    $(".filters a").removeClass("selected");
    $(this).addClass("selected");
    if(strshow == "All") $(".todo-list li").show();
    else if(strshow == "Active"){
        $(".todo-list li").show();
        $(".completed").hide();
    }else if(strshow == "Completed"){
        $(".todo-list li").hide();
        $(".completed").show();
    } 
});