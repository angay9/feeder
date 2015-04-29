package com.example.taraskin.newsservice;

import android.os.Bundle;
import android.os.StrictMode;
import android.support.v7.app.ActionBarActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.example.taraskin.newsservice.api.model.RegisterResponse;

import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;


@SuppressWarnings("ALL")
public class RegisterActivity extends ActionBarActivity {

    private static final String TAG = "RegisterActivity";

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
       if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode  .ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        TextView loginScreen = (TextView) findViewById(R.id.link_to_login);
        Button regButton=(Button) findViewById((R.id.btnRegister));


        loginScreen.setOnClickListener(new View.OnClickListener() {

            public void onClick(View arg0) {
                // Closing registration screen
                // Switching to Login Screen/closing register screen
                finish();
            }
        });

        regButton.setOnClickListener(new  View.OnClickListener(){

            public  void  onClick(View v){
                ((AppCore) getApplication()).getApiService().register("sadasd", "sdsda", "sdsad", "sdasdas", "dsfsdfsdfsdfsdf", new Callback<RegisterResponse>() {
                    @Override
                    public void success(RegisterResponse registerResponse, Response response) {

                    }

                    @Override
                    public void failure(RetrofitError error) {
                        if (error.getResponse() != null) {
                            RegisterResponse body = (RegisterResponse) error.getBodyAs(RegisterResponse.class);
                            Log.i(TAG, ""+body.getStatus());
                        }
                    }


                });
            }
        });
    }


    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_register, menu);
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
