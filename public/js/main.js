Configs = function(){
	window.command = new Command();
	this.orders = {
		"add" : "create",
		"update" : "update",
		"remove" : "confirm",
		"readAll" : "list",
		"read" : "details"
	}
	this.base_url = "http://localhost/crud/public";
}

Command = function()
{
	this.create = function(element)
	{
		Action = "C";
		validate = forms.validate();
		if (validate) {
			form = forms.getAll();
			url = configs.base_url+"/create";
			server.call("POST", url, form, function(data)
				{
					data = JSON.parse(data);
					if (isset(data.flag) && data.flag == 1) {
						actions.success(data.message);
						Items[data.items.id] = data.items;
					}
				}, function(){}, 
				function()
				{
					actions.waiting(element);
				}, function()
				{
					actions.completed();
					actions.loadItems();
				});
		}
	}
	this.delete = function(element)
	{
		delete_check = confirm("Do You Realy Want To Delete This");
		if (delete_check) {
			
			form = new FormData;
			if (isset(element.attr("delete"))) {
				id = element.attr("delete");
			}else{
				id = $(element).attr("delete");
			}

			form.append("id",id);
			server.call("post","delete",form,function(data)
				{
					data = JSON.parse(data);
					id = data.items.id;
					if (isset(data.flag) && data.flag == 1) {
						actions.success(data.message);
						delete Items[data.items.id];
						actions.delete(id);
					}
				},function(){},function(){},function(data)
				{
					actions.loadItems()
				});
		}
	}
	this.view = function(element)
	{
		actions.view(element);
	}
	this.cancel = function(element)
	{
		actions.cancel();
	}
	this.update = function(element)
	{
		Action = "U";
		id = element.attr('update');
		validate = forms.validate();
		if (validate) {
			form = forms.getAll();
			form.append("id", id);
			url = configs.base_url+"/update";
			server.call("POST", url, form, function(data)
				{
					data = JSON.parse(data);
					if (isset(data.flag) && data.flag == 1) {
						actions.success(data.message);
						Items[data.items.id].title = data.items.title;
						Items[data.items.id].category = data.items.category;
						Items[data.items.id].image = data.items.image;
					}
				}, function(){}, 
				function()
				{
					actions.waiting(element);
				}, function()
				{
					actions.cancel();
					actions.completed();
					actions.loadItems();
				});
		}
	}
}
Forms = function()
{
	$(".form-input").focusin(function(event) {
		actions.removeErrors();
	});
	this.validate = function()
	{
		validate = true;
		$(".form-input").each(function(index, el) {
			is_required = $(el).prop('required');
			type = $(el).attr('type');
			value = $(el).val();
			if (is_required) {
				if ((value =="" && Action == "C") || (value =="" && Action == "U" && type != "file")) {
					validate = false;
					$(el).addClass("input-alert");
				}
			}
		});
		return validate;
	}
	this.getAll = function()
	{
		form = new FormData($("form")[0	]);
		return form;
	}
}
Server = function()
{
	this.call = function(type, url, data, success, failuer, waiting, completed)
	{
		waiting();
		$.ajax({
				url: url,
				type: type,
				data: data,
				async: false,
				cache: false,
		        contentType: false,
		        processData: false,
				success: function (data) 
				{
					success(data);
				},
				error: function(xhr, error)
				{
			        failuer(xhr, error);
			 	},
			 	complete: function()
			 	{
			 		completed();
			 	}
			});
	}
}
Actions = function()
{
	this.waiting = function(element)
	{
		element.append(template.waiting);
	}
	this.success = function(message)
	{
		alert = template.success(message);
		$("html").append(alert);
	}
	this.completed = function(){
		$(".fa-spin").hide();
		$(".alert").fadeOut(2000);
		$(".form-input").val("");
	} 
	this.loadItems = function () {
		html_items ="";
		for (element in Items) {
			item = Items[element];
			item_template = template.item(item);
			html_items += item_template;
		}
		$("#item-group").html(html_items);
	}
	this.delete = function(id)
	{
		$("#item-"+id).hide();
	}
	this.view = function(element)
	{
		actions.removeErrors();
		id = element.attr("view");
		item = Items[id];
		$("#title").val(item.title);
		$("#category").val(item.category);
		$(".visible").hide("slow",function()
		{
			$(".update").show("slow");
			$(".update").attr("update",id);
			$(".update").removeClass("invisible");
		});
	}
	this.cancel = function()
	{
		$(".update").hide("slow",function()
		{
			$(".form-input").val("");
			$(".visible").show("slow");
		});
		actions.removeErrors();
	}
	this.removeErrors = function()
	{
		$(".form-input").removeClass('input-alert');
	}
}
Template = function()
{
	this.waiting = "<i class='fa fa-spinner fa-spin' ></i>";
	this.success = function(message)
	{
		return "<div class='alert alert-success col col-lg-4 col-md-4 col-sm-4 col-xs-4'><h4 class='alert-heading'> <i class='fa fa-check-square-o'></i> "+message+"</h4></div>";
	}
	this.item = function(item)
	{
		return"<div class=\"row item\" id=\"item-"+item.id+"\" item=\""+item.id+"\" dir=\"rtl\" style=\"background: yellow\">"+
				"<div class=\"col col-lg-3 middle-height title \" align=\"center\">"+
                    item.title + 
                "</div>"+
                "<div class=\"col col-lg-3 middle-height category\" align=\"center\">"+
                    item.category +
                "</div>"+
                "<div class=\"col col-lg-3 img\" align=\"center\">"+
                    "<img class=\"img-responsive img-thumbnail\" src=\""+item.image+"\" alt=\"\">"+
                "</div>"+
                "<div class=\"col col-lg-3 middle-height\" align=\"center\">"+
                    "<i delete=\""+item.id+"\" onclick=\"command.delete($(this))\" command=\"delete\" class=\"command-btn fa fa-window-close-o item-control\" ></i> "+
                    "<i view=\""+item.id+"\" onclick=\"command.view($(this))\" command=\"view\" class=\"command-btn fa fa-eye item-control\"></i>"+
                "</div>"+
               "</div>";
	}
}
call = function(class_name , function_name , param)
{
	window[class_name][function_name](param) ;
}
isset = function(value)
{
	if (typeof value === "undefined") {
		return false;
	}
	return true;
}
configs = new Configs();
forms = new Forms();
server = new Server();
actions = new Actions();
template = new Template();
var Items = {};
var Action = "";