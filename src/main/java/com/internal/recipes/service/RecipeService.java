package com.internal.recipes.service;

import java.util.List;

import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import com.internal.recipes.domain.Recipe;
import com.internal.recipes.repository.RecipeRepository;

@Service
public class RecipeService {
	
	@Autowired
	RecipeRepository recipeRepository;
	
	public List<Recipe> getAllRecipes() {
		return recipeRepository.getAllRecipes();
	}
	
	// additional business methods here

}
