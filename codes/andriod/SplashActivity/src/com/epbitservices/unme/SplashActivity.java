package com.epbitservices.unme;

import android.app.Activity;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.widget.ImageView;

import com.android.slidingmenu.MainActivity;
import com.epbitservices.unme.utility.AppLog;
import com.epbitservices.unme.utility.Constant;

public class SplashActivity extends Activity {
	private static final String TAG = "SplashActivity";
	protected boolean _active = true;
	private SharedPreferences preferences;
	protected ImageView imageView;
	private Thread splashTread;

	/** The _splash time. */
	protected int _splashTime = 1000;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		// TODO Auto-generated method stub
		super.onCreate(savedInstanceState);
		setContentView(R.layout.splashactivity);
		imageView=(ImageView)findViewById(R.id.logo);
		preferences = PreferenceManager.getDefaultSharedPreferences(this);
		splashTread = new Thread() {
			@Override
			public void run() {
				try {
					int waited = 0;
					while (_active && (waited < _splashTime)) {
						sleep(100);
						if (_active) {
							waited += 100;
						}
					}
				} catch (InterruptedException e) {
					finish();
				} finally {
					try {

						if (!preferences.getString(Constant.FACEBOOK_ID, "")
								.equals("")) {
							Intent mIntent = new Intent(SplashActivity.this,
									MainActivity.class);
							startActivity(mIntent);
							finish();

						} else {
							AppLog.Log(TAG, "onCreate  user not loged in ");
							Intent mIntent = new Intent(SplashActivity.this,
									LoginNew.class);
							startActivity(mIntent);
							finish();
						}

					} catch (Exception e2) {
						AppLog.Log(TAG, "onCreate  Exception " + e2);
					}
				}
			}
		};
		splashTread.start();

	}

	@Override
	public void onBackPressed() {
		splashTread.interrupt();
		super.onBackPressed();
	}
}
