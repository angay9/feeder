package com.example.taraskin.newsservice;

import android.app.AlertDialog;
import android.content.Intent;
import android.os.Bundle;
import android.os.StrictMode;
import android.support.v7.app.ActionBarActivity;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.Button;
import android.widget.TextView;

import com.example.taraskin.newsservice.Core.DB.Models.SQLiteHandler;
import com.example.taraskin.newsservice.Utilities.View.Alert;
import com.example.taraskin.newsservice.api.model.RegisterResponse;
import com.example.taraskin.newsservice.api.model.RegisterResponseError;
import com.example.taraskin.newsservice.api.requestModels.User.User;
import com.mobsandgeeks.saripaar.ValidationError;
import com.mobsandgeeks.saripaar.Validator;
import com.mobsandgeeks.saripaar.annotation.ConfirmPassword;
import com.mobsandgeeks.saripaar.annotation.Email;
import com.mobsandgeeks.saripaar.annotation.NotEmpty;
import com.mobsandgeeks.saripaar.annotation.Password;
import com.mobsandgeeks.saripaar.annotation.Size;

import java.util.List;
import java.util.UUID;

import retrofit.Callback;
import retrofit.RetrofitError;
import retrofit.client.Response;


@SuppressWarnings("ALL")
public class RegisterActivity extends ActionBarActivity implements Validator.ValidationListener {

    private static final String TAG = "RegisterActivity";

    private Validator validator;
    private SessionManager session;
    private SQLiteHandler db;

    @NotEmpty()
    @Size(min=4, message="Should be more that 4 characters")
    private TextView nameText;

    @NotEmpty
    @Email
    private TextView emailText;

    @NotEmpty
    @Password(min = 6)
    private TextView passwordText;

    @NotEmpty
    @ConfirmPassword
    private TextView passwordConfirmationText;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_register);
        // Session manager
        session = new SessionManager(getApplicationContext());
        // SQLite database handler
        db = new SQLiteHandler(getApplicationContext());
        // Check if user is already logged in or not
        if (session.isLoggedIn()) {
            // User is already logged in. Take him to main activity
            Intent intent = new Intent(RegisterActivity.this,
                    MainActivity.class);
            startActivity(intent);
            finish();
        }

       if (android.os.Build.VERSION.SDK_INT > 9) {
            StrictMode.ThreadPolicy policy = new StrictMode.ThreadPolicy.Builder().permitAll().build();
            StrictMode.setThreadPolicy(policy);
        }

        TextView loginScreen = (TextView) findViewById(R.id.link_to_login);
        Button regButton=(Button) findViewById((R.id.btnRegister));

        validator = new Validator(this);
        validator.setValidationListener(this);

        loginScreen.setOnClickListener(new View.OnClickListener() {

            public void onClick(View arg0) {
                Intent i = new Intent(getApplicationContext(), LoginActivity.class);
                startActivity(i);
                finish();
            }
        });

        regButton.setOnClickListener(new  View.OnClickListener(){

            public  void  onClick(View v){
                nameText = (TextView) findViewById(R.id.reg_fullname);
                emailText = (TextView) findViewById(R.id.reg_email);
                passwordText = (TextView) findViewById(R.id.reg_password);
                passwordConfirmationText = (TextView) findViewById(R.id.reg_again_password);
                validator.validate();
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

    @Override
    public void onValidationSucceeded() {
        final String NAME=nameText.getText().toString();
        final String EMAIL=emailText.getText().toString();
        final String PASSWORD=passwordText.getText().toString();
        final String PASSWORD_CONFIRMATION= passwordConfirmationText.getText().toString();
        final String uuid = UUID.randomUUID().toString();
        db.addUser(NAME,EMAIL,PASSWORD,uuid);
        ((AppCore) getApplication())
                .getApiService()
                .register(new User(NAME,EMAIL,PASSWORD,PASSWORD_CONFIRMATION,uuid),
                    new Callback<RegisterResponse>() {

            @Override
            public void success(RegisterResponse registerResponse, Response response) {
                Alert.makeSimpleAlert(RegisterActivity.this,
                        "Registration status",
                        "Your account has been registered",
                        "Ok",
                        null
                ).create().show();


            }
            @Override
            public void failure(RetrofitError error) {
                AlertDialog.Builder alert = Alert.makeSimpleAlert(RegisterActivity.this,
                        "Registration status",
                        "",
                        "Ok",
                        null
                );

                if (error.getResponse() != null) {
                    RegisterResponseError err = (RegisterResponseError)error.getBodyAs(RegisterResponseError.class);
                    // Error occured
                    alert.setMessage(err.getMessages().getErrors()).create().show();
                }
                alert.setMessage("Server error occured. Please try again later.").create().show();
            }


        });
        nameText.setText(null);
        emailText.setText(null);
        passwordText.setText(null);
        passwordConfirmationText.setText(null);


    }

    @Override
    public void onValidationFailed(List<ValidationError> errors) {
        for (ValidationError error : errors) {
            View view = error.getView();
            String message = error.getCollatedErrorMessage(this);
            // Display error messages
            if (view instanceof TextView) {
                ((TextView) view).setError(message);
            }
        }
    }
}
