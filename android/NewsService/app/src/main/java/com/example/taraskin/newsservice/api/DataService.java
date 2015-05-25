package com.example.taraskin.newsservice.api;

import com.example.taraskin.newsservice.api.model.RegisterResponse;
import com.example.taraskin.newsservice.api.requestModels.User.User;

import retrofit.Callback;
import retrofit.http.Body;
import retrofit.http.POST;

/**
 * Created by Taraskin on 28.04.2015.
 */
public interface DataService {

    @POST("/users")
    void register(@Body User user, Callback<RegisterResponse> response);

}
