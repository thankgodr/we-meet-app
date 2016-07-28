package com.epbitservices.unme.utility;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;

import com.epbitservices.unme.R;

public class AlertDialogManager {

	public static void errorMessage(Context context, String title,
			String message) {
		AlertDialog.Builder builder = new AlertDialog.Builder(context);
		builder.setTitle(title);
		builder.setMessage(message);

		builder.setPositiveButton(
				context.getResources().getString(R.string.okbuttontext),
				new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						dialog.dismiss();
					}
				});

		AlertDialog alert = builder.create();
		alert.setCancelable(false);
		alert.show();
	}

	/**
	 * Dialog to show No internet connection
	 */
	public static void internetConnetionErrorAlertDialog(final Activity activity) {
		AlertDialog.Builder builder = new AlertDialog.Builder(activity);
		builder.setTitle(R.string.no_network);
		builder.setMessage(R.string.internet_connction);

		builder.setNegativeButton(
				activity.getResources().getString(R.string.okbuttontext),
				new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						dialog.dismiss();
//						 Intent intent=new Intent(SplashActivity.this,
//						 HomeActivity.class);
//						 intent.setFlags(Intent.FLAG_ACTIVITY_SINGLE_TOP);
//						 startActivity(intent);
						activity.finish();

					}
				});

		AlertDialog alert = builder.create();
		alert.setCancelable(false);
		alert.show();
	}
	public static void internetSpeedErrorAlertDialog(final Activity activity) {
		AlertDialog.Builder builder = new AlertDialog.Builder(activity);
		builder.setTitle(R.string.internet_speed);
		builder.setMessage(R.string.internet_fast_message);

		builder.setNegativeButton(
				activity.getResources().getString(R.string.okbuttontext),
				new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
					;
						
						// startActivity(intent);
						
						Intent intent = new Intent(Intent.ACTION_MAIN);
						intent.addCategory(Intent.CATEGORY_HOME);
						intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
						activity.startActivity(intent);
						dialog.dismiss();
						activity.finish();

					}
				});

		AlertDialog alert = builder.create();
		alert.setCancelable(false);
		alert.show();
	}

}
