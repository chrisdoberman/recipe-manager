package com.internal.recipes.repository;

import java.util.List;

import org.springframework.data.repository.RepositoryDefinition;

import com.internal.recipes.domain.Recipe;

@RepositoryDefinition(domainClass = Recipe.class, idClass = String.class)
public interface RecipeRepository {

	Recipe save(Recipe entity);

	Recipe findOne(String primaryKey);

	List<Recipe> findAll();

	Long count();

	void delete(Recipe entity);

	boolean exists(String primaryKey);

}