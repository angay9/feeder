package com.example.taraskin.newsservice.Utilities.View;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.DialogInterface;

public class Alert {

    public static AlertDialog.Builder makeSimpleAlert(
            Activity activity,
            String title,
            String message,
            String positiveBtnText,
            DialogInterface.OnClickListener listener
    ) {
        AlertDialog.Builder alert  = new AlertDialog.Builder(activity);
        alert.setMessage(message);
        alert.setTitle(title);
        alert.setPositiveButton(positiveBtnText, listener);
        alert.setCancelable(true);
        return alert;
    }
}
