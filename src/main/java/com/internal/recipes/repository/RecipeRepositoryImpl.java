package com.internal.recipes.repository;

import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.data.mongodb.core.MongoTemplate;
import org.springframework.stereotype.Repository;

import com.internal.recipes.domain.Recipe;

@Repository
public class RecipeRepositoryImpl implements RecipeRepository {
	
	static final Logger logger = LoggerFactory.getLogger(RecipeRepositoryImpl.class);
	
	@Autowired
	private MongoTemplate mongoTemplate;
	
	/* (non-Javadoc)
	 * @see com.internal.recipes.repository.RecipeRepository#getAllRecipes()
	 */
	public List<Recipe> getAllRecipes(){
		return mongoTemplate.findAll(Recipe.class);
	}
	
	/* (non-Javadoc)
	 * @see com.internal.recipes.repository.RecipeRepository#createRecipe(com.internal.recipes.domain.Recipe)
	 */
	public void createRecipe(Recipe recipe){
		mongoTemplate.insert(recipe);
	}
	
	/* (non-Javadoc)
	 * @see com.internal.recipes.repository.RecipeRepository#updateRecipe(com.internal.recipes.domain.Recipe)
	 */
	public void updateRecipe(Recipe recipe) {
		mongoTemplate.save(recipe);
	}
	
	/* (non-Javadoc)
	 * @see com.internal.recipes.repository.RecipeRepository#deleteRecipe(com.internal.recipes.domain.Recipe)
	 */
	public void deleteRecipe(Recipe recipe) {
		mongoTemplate.remove(recipe);
	}
	
	/* (non-Javadoc)
	 * @see com.internal.recipes.repository.RecipeRepository#getRecipeById(java.lang.String)
	 */
	public Recipe getRecipeById(String recipeId) {
		return mongoTemplate.findById(recipeId, Recipe.class);
	}
	
	/* (non-Javadoc)
	 * @see com.internal.recipes.repository.RecipeRepository#createRecipeCollection()
	 */
	public void createRecipeCollection() {
        if (!mongoTemplate.collectionExists(Recipe.class)) {
            mongoTemplate.createCollection(Recipe.class);
        }
    }
 
    /* (non-Javadoc)
	 * @see com.internal.recipes.repository.RecipeRepository#dropRecipeCollection()
	 */
    public void dropRecipeCollection() {
        if (mongoTemplate.collectionExists(Recipe.class)) {
            mongoTemplate.dropCollection(Recipe.class);
        }
    }

}
