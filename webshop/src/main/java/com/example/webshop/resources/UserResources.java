package com.example.webshop.resources;

import com.example.webshop.model.User;
import com.example.webshop.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.web.bind.annotation.*;

@RestController
public class UserResources {

    @Autowired
    UserRepository userRepository;

    /*@GetMapping(value="login")
    public User Login(@RequestBody String email, @RequestBody String password){

        User user = userRepository.findByEmail(email);
        if (user.getPassword() == password) {
            return user;
        }
        else return null;
    }*/
    @GetMapping("/")
    public String home(){
        return "welocme home";
    }

    @GetMapping(value="/user")
    public String Greeting()
    {
        return "hello user";
    }

    @GetMapping(value="/admin")
    public String GreetingAdmin()
    {
        return "hello admin";
    }



}
