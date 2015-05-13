package com.example.taraskin.newsservice.api.model;

/**
 * Created by andriy on 13.05.15.
 */
public class RegisterResponseSuccess extends RegisterResponse {

    private String status;

    private String[] data;

    public String getStatus ()
    {
        return status;
    }

    public void setStatus (String status)
    {
        this.status = status;
    }

    public String[] getData ()
    {
        return data;
    }

    public void setData (String[] data)
    {
        this.data = data;
    }

    @Override
    public String toString()
    {
        return "ClassPojo [status = "+status+", data = "+data+"]";
    }
}
