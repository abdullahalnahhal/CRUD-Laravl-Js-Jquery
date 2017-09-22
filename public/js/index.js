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