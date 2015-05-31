package com.example.taraskin.newsservice;

import android.app.Activity;
import android.util.Log;

import com.example.taraskin.newsservice.JSONParser;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;

/**
 * Created by Taraskin on 28.05.2015.
 */
public class Chanels extends Activity{

    ArrayList<HashMap<String, Object>> jsonlist = new ArrayList<HashMap<String, Object>>();
    ArrayList<HashMap<String, Object>> jsonTypesItem;
    ArrayList<ArrayList<HashMap<String, Object>>> jsonTypesItems=new ArrayList<ArrayList<HashMap<String, Object>>>();

    private static final String T ="title";
    private static final String I="icon";
    private static final String N="name";
    private static final String TYPE="type";

    public static String NewsNAME;
    public static String IconName;
    public static String NewsTITLE;
    public static String NewsTYPE;

    public void getChanels(String url){
        JSONParser jParser = new JSONParser();

        // get JSON data from URL
        JSONObject json = jParser.getJSONFromUrl(url);


        try {
            JSONObject c = json.getJSONObject("data");
            Iterator<String> keysIterator = c.keys();
            HashMap<String, Object> map;

            while (keysIterator.hasNext())
            {
                NewsNAME = (String)keysIterator.next();
                IconName=NewsNAME+"i";
                JSONObject jsonNewsName=c.getJSONObject(NewsNAME);
                //jsonNews.put(jsonNewsName);
                JSONArray jsonTypesNew=jsonNewsName.getJSONArray("feedTypes");
                jsonTypesItem=new ArrayList<HashMap<String, Object>>();
                for(int i=0;i<jsonTypesNew.length();i++){
                    //JSONObject jsonType=jsonTypesNew.getJSONObject(i);



                    String type=jsonTypesNew.getString(i);
                    map=new HashMap<String, Object>();
                    map.put(TYPE,type);

                    jsonTypesItem.add(map);
                }
                jsonTypesItems.add(jsonTypesItem);

                int stringID = getResources().getIdentifier(NewsNAME , "string", getPackageName());
                NewsTITLE = getResources().getString(stringID);

                int ICON=getResources().getIdentifier(IconName , "drawable", getPackageName());

                map = new HashMap<String, Object>();
                //map.put(I,ICON);
                map.put(T,NewsTITLE);
                map.put(N,NewsNAME);


                jsonlist.add(map);
            }




        } catch (JSONException e) {
            Log.e("JSON ", "Error type " + e.toString());
        }
    }



}
