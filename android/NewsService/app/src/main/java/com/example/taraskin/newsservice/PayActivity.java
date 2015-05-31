package com.example.taraskin.newsservice;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ListActivity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.os.StrictMode;
import android.support.v7.app.ActionBarActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;
import android.widget.Toast;

import com.example.taraskin.newsservice.api.JSONParserPayments;

import org.apache.http.HttpEntity;
import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.StatusLine;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.protocol.HTTP;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStream;
import java.io.InputStreamReader;
import java.io.UnsupportedEncodingException;
import java.util.ArrayList;


public class PayActivity extends Activity {

    Button btnPay;
    Button btnCancel;
    TextView txtPrice;

    static String idService;
    static String encodedData;
    static String uid;
    static String price;
    static String url = "http://192.168.56.1:8080//api/payments";
    static String status;
    //static String message=null;
   // static String data=null;

    final static String MESSAGE="You have already purchased this service.";
    final static String DATA="Operation was succesful.";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pay);
        btnPay = (Button) findViewById(R.id.btnPay);

        Bundle extras = getIntent().getExtras();

        price = extras.getString("price");
        idService = extras.getString("idService");
        encodedData = extras.getString("encodedData");
        uid = extras.getString("uid");

        txtPrice = (TextView) findViewById(R.id.txtPrice);
        txtPrice.setText(price);

        btnPay.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                new ProgressTask(PayActivity.this).execute();
            }
        });




        /*StrictMode.setThreadPolicy(new StrictMode.ThreadPolicy.Builder()
                .detectDiskReads()
                .detectDiskWrites()
                .detectNetwork()   // or .detectAll() for all detectable problems
                .penaltyLog()
                .build());*/
    }


    private class ProgressTask extends AsyncTask<String, Void, Boolean> {
        private ProgressDialog dialog;
        private Activity activity;


        public ProgressTask(Activity activity) {
            this.activity = activity;
            context = activity;
            dialog = new ProgressDialog(context);
        }

        private Context context;

        protected void onPreExecute() {

            this.dialog.setMessage("Progress start");
            this.dialog.show();
        }

        @Override
        protected void onPostExecute(final Boolean success) {
            if (dialog.isShowing()) {
                dialog.dismiss();

            }
            setMassege(status);

        }


        protected Boolean doInBackground(final String... args) {


            JSONParserPayments jParser = new JSONParserPayments();
            JSONObject jobject = jParser.getJSONFromUrl(url, "Basic " + encodedData, uid, idService);
            try {
                status = jobject.getString("status").toString();
               /* data=jobject.getString("data").toString();
                JSONArray jarray=jobject.getJSONArray("messages");
                message=jarray.toString();*/

            } catch (JSONException e) {
                e.printStackTrace();
            }



            return null;
        }


    }

    public void setMassege(String status)
    {
        AlertDialog.Builder builder1 = new AlertDialog.Builder(this);
        if (status.equals("success")) {


            builder1.setMessage("Service is paid");
            builder1.setPositiveButton("Ok",
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            dialog.cancel();
                        }
                    });



        } else {
            builder1.setMessage("Error");
            builder1.setPositiveButton("Ok",
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            dialog.cancel();
                        }
                    });
        }
        AlertDialog alert11 = builder1.create();
        alert11.show();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_pay, menu);
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
