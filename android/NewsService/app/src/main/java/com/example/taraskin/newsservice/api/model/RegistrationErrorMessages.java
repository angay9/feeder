package com.example.taraskin.newsservice.api.model;

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
}
