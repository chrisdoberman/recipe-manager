package com.internal.recipes.domain;

import java.util.HashSet;
import java.util.Set;

public class User {

	private String userName;
	private String password;
	private Set<Role> roles = new HashSet<Role>();
	
	public User(String userName, String password) {
		this.userName = userName;
		this.password = password;
		roles.add(Role.ROLE_GUEST);
	}
	
	public String getUserName() {
		return userName;
	}
	public void setUserName(String userName) {
		this.userName = userName;
	}
	public String getPassword() {
		return password;
	}
	public void setPassword(String password) {
		this.password = password;
	}
	public Set<Role> getRoles() {
		return roles;
	}
	public void setRoles(Set<Role> roles) {
		this.roles = roles;
	}
	
	
}
