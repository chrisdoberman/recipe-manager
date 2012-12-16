package com.internal.recipes;

import java.util.List;

import org.slf4j.Logger;
import org.slf4j.LoggerFactory;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Controller;
import org.springframework.web.bind.annotation.RequestMapping;
import org.springframework.web.bind.annotation.RequestMethod;
import org.springframework.web.bind.annotation.ResponseBody;

import com.internal.recipes.domain.User;
import com.internal.recipes.service.UserService;

@Controller
@RequestMapping(value = "/users")
public class UserController {

	@Autowired
	UserService userService;
	
	private static final Logger logger = LoggerFactory.getLogger(UserController.class);
	
	@RequestMapping(method = RequestMethod.GET)
	public @ResponseBody List<User> getAllUsers() {
		logger.info("Request to get all users.");
		return userService.getAllUsers();
	}
}
