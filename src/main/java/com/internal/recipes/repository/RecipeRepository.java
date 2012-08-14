package com.internal.recipes.repository;

import java.util.List;

import com.internal.recipes.domain.Recipe;

public interface RecipeRepository {

	public List<Recipe> getAllRecipes();

	public void createRecipe(Recipe recipe);

	public void updateRecipe(Recipe recipe);

	public void deleteRecipe(Recipe recipe);

	public Recipe getRecipeById(String recipeId);

	public void createRecipeCollection();

	public void dropRecipeCollection();

}