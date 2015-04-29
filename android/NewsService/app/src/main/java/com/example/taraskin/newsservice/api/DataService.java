package com.example.taraskin.newsservice.api;

import com.example.taraskin.newsservice.api.model.RegisterResponse;

import retrofit.Callback;
import retrofit.http.Header;
import retrofit.http.POST;

/**
 * Created by Taraskin on 28.04.2015.
 */
public interface DataService {

    @POST("/users")
    void register(@Header("name") String name,
                  @Header("email") String email,
                  @Header("password") String password,
                  @Header("password_confirmation") String password_confirmation,
                  @Header("guid") String guid, Callback<RegisterResponse> response);


}
