package com.internal.recipes.repository;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertNotNull;

import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.springframework.context.ApplicationContext;
import org.springframework.context.support.ClassPathXmlApplicationContext;

import com.internal.recipes.domain.Recipe;

public class RecipeRepositoryTest {
	
	private RecipeRepository recipeRepository;

	@Before
	public void setUp() throws Exception {
		ApplicationContext applicationContext = new ClassPathXmlApplicationContext(
				"META-INF/spring/app-context.xml");
		
		recipeRepository = applicationContext.getBean(RecipeRepositoryImpl.class);
		assertNotNull(recipeRepository);
		
		recipeRepository.createRecipeCollection();
	}

	@After
	public void tearDown() throws Exception {
		//recipeRepository.dropRecipeCollection();
	}

	@Test
	public void testCreate() {
		
		Recipe recipe = new Recipe("first recipe name", "test description", "http://blah.com", "first note");
		recipeRepository.createRecipe(recipe);
		assertNotNull(recipe.getRecipeId());
		assertEquals(1, recipeRepository.getAllRecipes().size());
	}
	
	@Test
	public void testFindById() {
		Recipe recipe = new Recipe("second recipe name", "test description for get", "http://blah.com", "first note");
		recipeRepository.createRecipe(recipe);
		Recipe actual = recipeRepository.getRecipeById(recipe.getRecipeId());
		assertEquals(recipe.getDescription(), actual.getDescription());
	}

}
