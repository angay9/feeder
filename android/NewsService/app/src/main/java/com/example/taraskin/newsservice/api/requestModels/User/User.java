package com.example.taraskin.newsservice.api.requestModels.User;

/**
 * Created by andriy on 13.05.15.
 */
public class User {
    public String name;

    public String email;

    public String password;

    public String password_confirmation;

    public String guid;

    public User (String name, String email, String password, String password_confirmation, String guid) {

        this.name = name;
        this.email = email;
        this.password = password;
        this.password_confirmation = password_confirmation;
        this.guid = guid;
    }
}
