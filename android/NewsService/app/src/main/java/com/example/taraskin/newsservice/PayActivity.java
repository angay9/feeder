package com.example.taraskin.newsservice;

import android.app.Activity;
import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.os.AsyncTask;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;


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

    static String message;
    JSONObject responseObject;
   // static String data=null;

    final static String MESSAGE="You have already purchased this service.";
    final static String DATA="Operation was succesful.";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_pay);
        btnPay = (Button) findViewById(R.id.btnPay);
        btnCancel =(Button) findViewById(R.id.btnCancel);

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

        btnCancel.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View v) {
                finish();
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
            setMassege(responseObject);

        }


        protected Boolean doInBackground(final String... args) {


            JSONParserPayments jParser = new JSONParserPayments();
            JSONObject jobject = responseObject = jParser.getJSONFromUrl(url, "Basic " + encodedData, uid, idService);
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

    public void setMassege(JSONObject obj)
    {
        AlertDialog.Builder builder1 = new AlertDialog.Builder(this);
//        if (status.equals("success")) {
        try {
            if (obj.getString("status").equals("success")) {

                builder1.setMessage("Service is paid");
                builder1.setPositiveButton("Ok",
                        new DialogInterface.OnClickListener() {
                            public void onClick(DialogInterface dialog, int id) {
                                dialog.cancel();
                            }
                        });



        } else {
            JSONArray msgs = obj.getJSONArray("messages");
            String msg = "";
            for (int i = 0, len = msgs.length(); i < len; i++) {
                msg += msgs.getString(i) + "\r\n";
            }
            builder1.setMessage(msg);
            builder1.setPositiveButton("Ok",
                    new DialogInterface.OnClickListener() {
                        public void onClick(DialogInterface dialog, int id) {
                            dialog.cancel();
                        }
                    });
        }
        } catch (JSONException e) {
            e.printStackTrace();
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
