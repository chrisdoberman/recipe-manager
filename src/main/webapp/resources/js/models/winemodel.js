window.Wine = Backbone.Model.extend({
	urlRoot: "recipes",
	defaults: {
		"recipeId": null,
	    "title":  "",
	    "description":  "",
	    "url":  "http://",
	    "notes":  ""
	  }
});

window.WineCollection = Backbone.Collection.extend({
	model: Wine,
	url: "recipes"
});