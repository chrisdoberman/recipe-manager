package com.internal.recipes.repository;

import static org.junit.Assert.*;
import static org.junit.Assert.assertNotNull;

import org.junit.After;
import org.junit.Before;
import org.junit.Test;
import org.springframework.context.ApplicationContext;
import org.springframework.context.support.ClassPathXmlApplicationContext;
import org.springframework.data.mongodb.core.MongoTemplate;

import com.internal.recipes.domain.User;

public class UserRepositoryTest {

	private UserRepository userRepository;
	private MongoTemplate mt;

	@Before
	public void setUp() throws Exception {
		ApplicationContext applicationContext = new ClassPathXmlApplicationContext(
				"META-INF/spring/app-context.xml");
		
		userRepository = (UserRepository) applicationContext.getBean("userRepository");
		mt = applicationContext.getBean(MongoTemplate.class);
		
		assertNotNull(userRepository);
		assertNotNull(mt);
		
	}

	@After
	public void tearDown() throws Exception {
		mt.dropCollection(User.class);
	}
	@Test
	public void test() {
		User user = new User("cherb", "password");
		userRepository.save(user);
		assertTrue(userRepository.exists(user.getId()));
	}

}
