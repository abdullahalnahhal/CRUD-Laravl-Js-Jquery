function init()
{
	$(".command-btn").click(function() {
		cmd = $(this).attr('command');
		param = null;
		attr = $(this).attr('param');
		if (typeof attr !== typeof undefiend && attr !== false) {
			param = attr;
		}
		call("command", cmd, $(this));
	});
}
init();
$(".item").each(function(index, el) {
	item = {}
	item["id"] = $(el).attr("item");
	item["title"] = $(el).children('.title').text().trim();
	item["category"] = $(el).children('.category').text().trim();
	item["image"] = $(el).children('.img').children('img').attr("src");
	Items[item["id"]] = item;
});