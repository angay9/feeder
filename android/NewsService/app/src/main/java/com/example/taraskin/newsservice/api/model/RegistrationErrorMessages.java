package com.example.taraskin.newsservice.api.model;

import android.text.TextUtils;

import java.lang.reflect.Array;
import java.util.HashMap;

/**
 * Created by andriy on 13.05.15.
 */
public class RegistrationErrorMessages {


    private String[] guid;

    private String[] email;

    private String[] name;

    private String[] password_confirmation;

    private String[] password;

    public String[] getGuid ()
    {
        return guid;
    }

    public void setGuid (String[] guid)
    {
        this.guid = guid;
    }

    public String[] getEmail ()
    {
        return email;
    }

    public void setEmail (String[] email)
    {
        this.email = email;
    }

    public String[] getName ()
    {
        return name;
    }

    public void setName (String[] name)
    {
        this.name = name;
    }

    public String[] getPassword_confirmation ()
    {
        return password_confirmation;
    }

    public void setPassword_confirmation (String[] password_confirmation)
    {
        this.password_confirmation = password_confirmation;
    }

    public String[] getPassword ()
    {
        return password;
    }

    public void setPassword (String[] password)
    {
        this.password = password;
    }

    @Override
    public String toString()
    {
        return "ClassPojo [guid = "+guid+", email = "+email+", name = "+name+", password_confirmation = "+password_confirmation+", password = "+password+"]";
    }

    public String getErrors() {

        String errors = new String();

        if (this.getName() != null) {
            errors += TextUtils.join("\n", this.getName());
        }
        if (this.getEmail() != null) {
            errors += TextUtils.join("\n", this.getEmail());
        }
        if (this.getPassword() != null) {
            errors += TextUtils.join("\n", this.getPassword());
        }
        if (this.getPassword_confirmation() != null) {
            errors += TextUtils.join("\n", this.getPassword_confirmation());
        }
        if (this.getGuid() != null) {
            errors += TextUtils.join("\n", this.getGuid());
        }

        return errors;
    }
}
