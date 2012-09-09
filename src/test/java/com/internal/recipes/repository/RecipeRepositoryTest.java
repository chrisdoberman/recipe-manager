package com.internal.recipes.repository;

import static org.junit.Assert.assertEquals;
import static org.junit.Assert.assertNotNull;
import static org.junit.Assert.assertTrue;

import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.springframework.context.ApplicationContext;
import org.springframework.context.support.ClassPathXmlApplicationContext;
import org.springframework.data.mongodb.core.MongoTemplate;

import com.internal.recipes.domain.Recipe;

public class RecipeRepositoryTest {
	
	private RecipeRepository recipeRepository;
	private MongoTemplate mt;

	@Before
	public void setUp() throws Exception {
		ApplicationContext applicationContext = new ClassPathXmlApplicationContext(
				"META-INF/spring/app-context.xml");
		
		recipeRepository = (RecipeRepository) applicationContext.getBean("recipeRepository");
		mt = applicationContext.getBean(MongoTemplate.class);
		
		assertNotNull(recipeRepository);
		assertNotNull(mt);
		
	}

	@After
	public void tearDown() throws Exception {
		//recipeRepository.dropRecipeCollection();
		//mt.dropCollection(Recipe.class);
	}

	@Test
	public void testCreate() {
		Long count = recipeRepository.count();
		Recipe recipe = new Recipe("new recipe name", "test description", "http://blah.com", "using interface");
		recipeRepository.save(recipe);
		assertEquals(recipe.getRecipeId(), recipeRepository.findOne(recipe.getRecipeId()).getRecipeId());
		
		assertTrue(recipeRepository.exists(recipe.getRecipeId()));
		
		recipeRepository.delete(recipe);
		assertEquals(count, recipeRepository.count());
		
	}
	
	//@Test
	public void createTestData() {
		Recipe recipe = new Recipe("first recipe name", "test description", "http://blah.com", "using interface");
		recipeRepository.save(recipe);
		
		recipe = new Recipe("second recipe name", "test description 2", "http://blah2.com", "using interface2");
		recipeRepository.save(recipe);
	}
	
}
