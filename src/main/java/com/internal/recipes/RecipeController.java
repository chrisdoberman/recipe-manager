package com.internal.recipes;

import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.HttpStatus;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.PathVariable;
import org.springframework.web.bind.annotation.RequestBody;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;
import org.springframework.web.bind.annotation.ResponseStatus;

import com.internal.recipes.domain.Recipe;
import com.internal.recipes.service.RecipeService;

@Controller
@RequestMapping(value = "/recipes")
public class RecipeController {

	@Autowired
	private RecipeService recipeService;

	private static final Logger logger = LoggerFactory.getLogger(RecipeController.class);

	@RequestMapping(method = RequestMethod.GET)
	public @ResponseBody List<Recipe> getAllRecipes() {
		logger.info("Request to get all recipes.");
		return recipeService.getAllRecipes();
	}
	
	@RequestMapping(value = "/{id}", method = RequestMethod.GET)
	public @ResponseBody Recipe getRecipe(@PathVariable("id") final String id) {
		logger.info("Request to get one recipe with id: {}", id);
		return recipeService.get(id);
	}

	@RequestMapping(method = RequestMethod.POST)
	@ResponseStatus(HttpStatus.CREATED)
	public @ResponseBody Recipe create(@RequestBody final Recipe entity) {
		logger.info("Request to create a recipe");
		return recipeService.create(entity);
	}

	@RequestMapping(method = RequestMethod.PUT)
	@ResponseStatus(HttpStatus.OK)
	public @ResponseBody Recipe update(@RequestBody final Recipe entity) {
		logger.info("Request to update a recipe");
		return recipeService.update(entity);
	}

	@RequestMapping(value = "/{id}", method = RequestMethod.DELETE)
	@ResponseStatus(HttpStatus.OK)
	public void deleteRecipe(@PathVariable("id") final String id) {
		logger.info("Request to delete a recipe");
		Recipe recipe = new Recipe();
		recipe.setRecipeId(id);
		recipeService.delete(recipe);
	}

}
