package com.example.taraskin.newsservice.api.model;

import com.google.gson.annotations.SerializedName;

import org.json.JSONObject;

import java.util.HashMap;

/**
 * Created by Taraskin on 28.04.2015.
 */
public class RegisterResponse {

    @SerializedName("status")
    String status;
    @SerializedName("messages")
    HashMap<String, JSONObject> messages;
    @SerializedName("data")
    String[] data;

    public String getStatus() {
        return status;
    }

    public HashMap<String, JSONObject> getMessages() {
        return messages;
    }

    public String[] getData() {
        return data;
    }
}
