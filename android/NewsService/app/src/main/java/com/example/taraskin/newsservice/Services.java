package com.example.taraskin.newsservice;

import android.os.AsyncTask;
import android.util.Base64;
import android.util.Log;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;

/**
 * Created by Taraskin on 27.05.2015.
 */
public class Services extends AsyncTask<String, Void, Boolean>{

    private static String encodedData;
    private static String uid;

    private static final String ID="id";
    private static final String PRICE="price";
    private static final String NAME="name";
    private static final String FEED="feed";
    private static final String IS_ACTIVE="is_active";

    public ArrayList<HashMap<String,String>>services=new ArrayList<HashMap<String, String>>();


    private static final String URL2="http://192.168.56.1:8080//api/users/services/";

    public Services(){

    }

    /*public Services(String s_encodedData, String s_uid){
        encodedData = s_encodedData;
        uid = s_uid;

    }*/

    protected Boolean doInBackground(String... args) {


        JSONParserServices jsonParserServices=new JSONParserServices();
        JSONObject jobject=jsonParserServices.getJSONFromUrl(URL2,"k","k");

        try {
            JSONObject c = jobject.getJSONObject("data");
            JSONArray jarray=c.getJSONArray("services");
            for (int i=0;i<jarray.length();i++)
            {
                JSONObject service = jarray.getJSONObject(i);
                String sid=service.getString(ID);
                String sprice=service.getString(PRICE);
                String sname=service.getString(NAME);
                String sfeed=service.getString(FEED);
                String sis_active=service.getString(IS_ACTIVE);

                HashMap<String, String> map = new HashMap<String, String>();

                map.put(ID,sid);
                map.put(PRICE,sprice);
                map.put(NAME,sname);
                map.put(FEED,sfeed);
                map.put(IS_ACTIVE,sis_active);

                services.add(map);
            }


        } catch (JSONException e) {
            Log.e("JSON Service", "Error type " + e.toString());
        }

        return null;
    }



}
