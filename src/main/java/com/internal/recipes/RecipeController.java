package com.internal.recipes;

import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;

import com.internal.recipes.domain.Recipe;
import com.internal.recipes.service.RecipeService;

@Controller
@RequestMapping("/recipes")
public class RecipeController {


	@Autowired
	private RecipeService recipeService;
	
	private static final Logger logger = LoggerFactory.getLogger(HomeController.class);
	
	@RequestMapping(value = "/provider/recipes", method = RequestMethod.GET)
	public @ResponseBody List<Recipe> getAllRecipes() {
		logger.info("Request to get all recipes.");
		return recipeService.getAllRecipes();
	}
}
