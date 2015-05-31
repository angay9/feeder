package com.example.taraskin.newsservice;

import android.app.ListActivity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.Intent;
import android.os.AsyncTask;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.ListAdapter;
import android.widget.ListView;
import android.widget.SimpleAdapter;

import com.example.taraskin.newsservice.api.WebActivity;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.util.ArrayList;
import java.util.HashMap;


public class Types extends ListActivity {
    private static String NewsNAME;
    private static String NewsTYPE;
    private static String encodedData;
    private static String uid;
    private static String url="http://192.168.56.1:8080/api/feeds/";

    private static final int LIMIT=5;
    private static int offset=0;
    Button btnPrevious;
    Button btnNext;

    private static final String TITLE="title";
    private static final String LINK="link";
    private static final String DATE="pub_date";
    private static final String DESCRIPTION="description";
    ListView lv;

    ArrayList<HashMap<String, String>> jsonlist;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_types);
        new ProgressTask(Types.this).execute();

       btnPrevious=(Button) findViewById(R.id.btnPrevious);
        btnNext=(Button) findViewById(R.id.btnNext);

        btnPrevious.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                offset = offset == 0 ? 0 : offset--;

                if(offset > 0){

                    new ProgressTask(Types.this).execute();
                }

            }
        });

        btnNext.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                offset = offset+LIMIT;

                new ProgressTask(Types.this).execute();

            }
        });

    }


    private class ProgressTask extends AsyncTask<String, Void, Boolean> {
        private ProgressDialog dialog;
        private ListActivity activity;


        public ProgressTask(ListActivity activity) {
            this.activity = activity;
            context = activity;
            dialog = new ProgressDialog(context);
        }

        private Context context;

        protected void onPreExecute() {
            this.dialog.setMessage("Progress start");
            this.dialog.show();
            Bundle extras = getIntent().getExtras();
            NewsNAME=extras.getString("name");
            NewsTYPE=extras.getString("type");
            encodedData=extras.getString("encodedData");
            uid=extras.getString("uid");
            url=url+NewsNAME+"/"+NewsTYPE+"/"+offset+"/"+LIMIT;

        }


        @Override
        protected void onPostExecute(final Boolean success) {
            if (dialog.isShowing()) {
                dialog.dismiss();
            }
            ListAdapter adapter = new SimpleAdapter(
                    context,
                    jsonlist,
                    R.layout.list_item_news, new String[] { TITLE, DATE, DESCRIPTION },
                    new int[] { R.id.txtTitle, R.id.txtDate, R.id.txtDescription});
            setListAdapter(adapter);
            lv=getListView();

            lv.setOnItemClickListener(new AdapterView.OnItemClickListener() {
                @Override
                public void onItemClick(AdapterView<?> parent, View view, int position, long id) {
                    String link=jsonlist.get(position).get(LINK);
                    Intent intent=new Intent(Types.this, WebActivity.class);
                    intent.putExtra("link", link);
                    startActivity(intent);

                }
            });

            btnPrevious=(Button) findViewById(R.id.btnPrevious);
            btnNext=(Button) findViewById(R.id.btnNext);







        }

        protected Boolean doInBackground(final String... args) {

            jsonlist = new ArrayList<HashMap<String, String>>();
            JSONParserNews jParser = new JSONParserNews();

            JSONArray json = jParser.getJSONFromUrl(url, "Basic "+encodedData,uid);
            for (int i = 0; i < json.length(); i++) {
                try {
                    JSONObject c = json.getJSONObject(i);
                    String ntitle=c.getString(TITLE);
                    String nlink=c.getString(LINK);
                    String ndate=c.getString(DATE);
                    String ndescription=c.getString(DESCRIPTION);

                    HashMap<String, String> map = new HashMap<String, String>();

                    map.put(TITLE,ntitle);
                    map.put(LINK,nlink);
                    map.put(DATE,ndate);
                    map.put(DESCRIPTION,ndescription);
                    jsonlist.add(map);
                }
                catch (JSONException e) {
                    Log.e("JSON ", "Error type " + e.toString());
                }

            }





            return null;


        }

    }




    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_types, menu);
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
