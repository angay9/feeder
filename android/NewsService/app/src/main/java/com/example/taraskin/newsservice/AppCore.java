package com.example.taraskin.newsservice;

import android.app.Application;

import com.activeandroid.ActiveAndroid;
import com.example.taraskin.newsservice.api.DataService;
import com.squareup.okhttp.OkHttpClient;

import java.util.concurrent.TimeUnit;

import retrofit.RequestInterceptor;
import retrofit.RestAdapter;
import retrofit.client.OkClient;

/**
 * Created by Taraskin on 28.04.2015.
 */
public class AppCore extends Application {

    private final String API_URL = "http://192.168.56.1:8080/api";
//    private final String API_URL = "http://10.0.2.2:8000/api";
    private DataService apiService;

    @Override
    public void onCreate() {
        super.onCreate();
        initServiceApi();
        initActiveAndroid();
    }

    private void initServiceApi() {

        final OkHttpClient okHttpClient = new OkHttpClient();
        okHttpClient.setReadTimeout(3, TimeUnit.SECONDS);
        okHttpClient.setConnectTimeout(3, TimeUnit.SECONDS);

        RequestInterceptor requestInterceptor = new RequestInterceptor() {
            @Override
            public void intercept(RequestFacade request) {
                request.addHeader("Content-Type", "application/json");
            }
        };


        RestAdapter restAdapter = new RestAdapter.Builder()
                .setEndpoint(API_URL)
                .setClient(new OkClient(okHttpClient))
                .setRequestInterceptor(requestInterceptor)
                .build();

        apiService = restAdapter.create(DataService.class);

    }

    public DataService getApiService() {
        return apiService;
    }

    public void initActiveAndroid() {
        ActiveAndroid.initialize(this);
    }
}
