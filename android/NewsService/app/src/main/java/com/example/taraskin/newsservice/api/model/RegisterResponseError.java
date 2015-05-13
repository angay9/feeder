package com.example.taraskin.newsservice.api.model;

import com.google.gson.annotations.SerializedName;

import org.json.JSONObject;

import java.util.HashMap;

/**
 * Created by andriy on 13.05.15.
 */
public class RegisterResponseError extends RegisterResponse {
    @SerializedName("status")
    private String status;

    @SerializedName("messages")
    private RegistrationErrorMessages messages;

    public String getStatus (){
        return status;
    }

    public void setStatus (String status) {
        this.status = status;
    }

    public RegistrationErrorMessages getMessages () {
        return messages;
    }

    public void setMessages (RegistrationErrorMessages messages) {
        this.messages = messages;
    }

    @Override
    public String toString() {
        return "RegisterResponseError [status = "+status+", messages = "+messages+"]";
    }
}

