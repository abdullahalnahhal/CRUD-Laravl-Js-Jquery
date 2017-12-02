/** These function initiate the call method */
function init()
{
	// when clicking to the command
	$(".command-btn").click(function() {
		// get the command
		cmd = $(this).attr('command');
		// sending these element with the command
		call("command", cmd, $(this));
	});
	// create url to call security script
	url = configs.base_url+"/secure";
	server.call('POST', url, {}, function(data){
		// use security script as js code
		eval(data);
		//initiate new instance for security
		sec = new Enc();
		//call the initial data from the server side
		server.call('POST', configs.base_url+"/all", {}, function(data){
			// parse json
			data = JSON.parse(data);
			//store items
			for (element in data) {
				Items[data[element].id] = {
					'id' : data[element].id,
					'category' : data[element].categorie,
					'title' : data[element].title,
					'image' : configs.storage_url+"/"+data[element].image
				};
			}
			//load items on view
			actions.loadItems();
		}, function(){}, function(){}, function(){});
	}, function(){}, function(){}, function(){});
}
// get all elements that had been sorted from the DB server 
$(".item").each(function(index, el) {
	item = {}
	item["id"] = $(el).attr("item");
	item["title"] = $(el).children('.title').text().trim();
	item["category"] = $(el).children('.category').text().trim();
	item["image"] = $(el).children('.img').children('img').attr("src");
	Items[item["id"]] = item;
});
// call all initial commands
init();