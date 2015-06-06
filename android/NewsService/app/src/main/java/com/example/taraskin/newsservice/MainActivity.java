package com.example.taraskin.newsservice;

import android.app.Activity;
import android.app.ExpandableListActivity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.drawable.Drawable;
import android.os.AsyncTask;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Base64;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.ExpandableListAdapter;
import android.widget.ExpandableListView;
import android.widget.ImageView;
import android.widget.SimpleExpandableListAdapter;
import android.widget.TextView;

import com.example.taraskin.newsservice.Core.DB.Models.SQLiteHandler;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;
import java.util.Iterator;
import java.util.Map;


public class MainActivity extends ExpandableListActivity {
    private Button btnLogout;
    private SessionManager session;


    private static String url="http://192.168.56.1:8080/api/info/";
    private static final String url2="http://192.168.56.1:8080//api/users/services/";

    private static final String ID="id";
    private static final String PRICE="price";
    private static final String NAME="name";
    private static final String FEED="feed";
    private static final String IS_ACTIVE="is_active";

    public ArrayList<HashMap<String,String>>services=new ArrayList<HashMap<String, String>>();






    //final LayoutInflater layoutInflater = (LayoutInflater) this.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
    private static String NewsNAME;
    private static String IconName;
    private static String NewsTITLE;
    private static String NewsTYPE;

    private static String username;
    private static String email;
    private static String password;
    private static String uid;
    private static String encodedData;
    private static String idService;
    private static int position;
    private static String price;

    private static final String T ="title";
    private static final String I="icon";
    private static final String N="name";
    private static final String TYPE="type";
    TextView txtUser;

    private SQLiteHandler db;

    JSONArray jsonNews=new JSONArray();
    ArrayList<HashMap<String, Object>> jsonlist = new ArrayList<HashMap<String, Object>>();
    ArrayList<HashMap<String, Object>> jsonTypesItem;
    ArrayList<ArrayList<HashMap<String, Object>>> jsonTypesItems=new ArrayList<ArrayList<HashMap<String, Object>>>();
    HashMap<String, String> user;
    ExpandableListView lv ;


    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        new ProgressTask(MainActivity.this).execute();





        btnLogout = (Button) findViewById(R.id.btnLogout);
        btnLogout.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {
                logoutUser();
            }
        });
    }

    private void logoutUser() {
        session.setLogin(false);

        //db.deleteUsers();

        // Launching the login activity
        Intent intent = new Intent(MainActivity.this, LoginActivity.class);
        startActivity(intent);
        finish();
    }

    private class ProgressTask extends AsyncTask<String, Void, Boolean> {
        private ProgressDialog dialog;
        private ExpandableListActivity activity;


        public ProgressTask(ExpandableListActivity activity) {
            this.activity = activity;
            context = activity;
            dialog = new ProgressDialog(context);

        }

        private Context context;

       protected void onPreExecute() {
            this.dialog.setMessage("Progress start");
            this.dialog.show();


           SharedPreferences prefs = getApplicationContext().getSharedPreferences("PREFS", Context.MODE_PRIVATE);
           email = prefs.getString("email", "");
           password = prefs.getString("password", "");


           /* Bundle extras = getIntent().getExtras();
            email=extras.getString("email");
            password=extras.getString("password");*/


            db = new SQLiteHandler(getApplicationContext());
            //user=db.getUserDetails("Bedos@test.com","password");
            user=db.getUserDetails(email,password);
            username=user.get("name");
            uid=user.get("uid");

           txtUser=(TextView) findViewById(R.id.txtUser);
           txtUser.setText(username);

        }


        @Override
        protected void onPostExecute(final Boolean success) {
            if (dialog.isShowing()) {
                dialog.dismiss();
            }

            ExpandableListAdapter adapter = new SimpleExpandableListAdapter(
                    context,
                    jsonlist,
                    R.layout.list_item,
                    new String[]{T},
                    //new String[]{T, I},
                    new int[]{R.id.text1},
                    // new int[]{R.id.text1, R.id.img},
                    jsonTypesItems,
                    R.layout.list_item_types,
                    new String[]{TYPE},
                    new int[]{R.id.text2});/*{

                @Override
                public View getGroupView(int groupPosition,  boolean isExpanded, View convertView, ViewGroup parent) {
                    final View v = super.getGroupView(groupPosition, isExpanded, convertView, parent);

                    // Populate your custom view here
                    ((TextView)v.findViewById(R.id.text1)).setText( (String) ((Map<String,Object>)getGroup(groupPosition)).get(T) );
                    ((ImageView)v.findViewById(R.id.img)).setImageDrawable( (Drawable) ((Map<String,Object>)getGroup(groupPosition)).get(I) );

                    return v;
                }


            });*/

            setListAdapter(adapter);

            lv = getExpandableListView();



            lv.setOnChildClickListener(new ExpandableListView.OnChildClickListener() {
                @Override
                public boolean onChildClick(ExpandableListView parent, View v, int groupPosition, int childPosition, long id) {
                    NewsNAME=jsonlist.get(groupPosition).get(N).toString();
                    NewsTYPE=jsonTypesItems.get(groupPosition).get(childPosition).get(TYPE).toString();
                    //encodedData=Encoding("Bedos@test.com","password");
                    //Services s=new Services();
                    //s.execute(new String[]{"Basic "+encodedData,uid});
                   // services=s.services;


                    if(isPaid()){
                        Intent intent=new Intent(MainActivity.this,Types.class);
                        intent.putExtra("name",NewsNAME);
                        intent.putExtra("type",NewsTYPE);
                        intent.putExtra("encodedData", encodedData);
                        intent.putExtra("uid", uid);
                        startActivity(intent);
                    }else {
                        Intent intent=new Intent(MainActivity.this,PayActivity.class);
                        idService=services.get(position).get("id").toString();
                        price=services.get(position).get("price").toString();
                        intent.putExtra("idService",idService);
                        intent.putExtra("encodedData", encodedData);
                        intent.putExtra("uid", uid);
                        intent.putExtra("price",price);
                        startActivity(intent);

                    }


                    return false;
                }
            });



        }

        protected Boolean doInBackground(final String... args) {

            session = new SessionManager(getApplicationContext());
            if (!session.isLoggedIn()) {
                logoutUser();
            }

            JSONParser jParser = new JSONParser();

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
                    map.put(I,ICON);
                    map.put(T,NewsTITLE);
                    map.put(N,NewsNAME);


                    jsonlist.add(map);
                }




            } catch (JSONException e) {
                Log.e("JSON ", "Error type " + e.toString());
            }




            encodedData=Encoding(email,password);
            //encodedData=Encoding("taraskin@mail.com","password");

            JSONParserServices jsonParserServices=new JSONParserServices();
            JSONObject jobject=jsonParserServices.getJSONFromUrl(url2,"Basic "+encodedData,uid); //"a5dc4540-4cc6-4b92-9de6-d48d8064176a"

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



    public Boolean isPaid(){
        Boolean isP=false;
        String t="true";
        for(int i=0;i<services.size();i++){
            String sNAME=services.get(i).get("name").toString();
            String sFEED=services.get(i).get("feed").toString();
            String sIsActive=services.get(i).get("is_active").toString();

            if(sNAME.equals(NewsNAME) && sFEED.equals(NewsTYPE) && sIsActive.equals(t)){

                isP=true;
            }
            else if (sNAME.equals(NewsNAME) && sFEED.equals(NewsTYPE)){
                position=i;
            }
        }
        return isP;
    }

    public String Encoding(String email, String password){
        String source=email+":"+password;
        String result= Base64.encodeToString(source.getBytes(), Base64.NO_WRAP);

        return result;
    }
    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings) {
            return true;
        }

        return super.onOptionsItemSelected(item);
    }
}
