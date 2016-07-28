package com.android.slidingmenu;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;

import android.app.AlertDialog;
import android.app.ProgressDialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.graphics.Color;
import android.graphics.Typeface;
import android.graphics.drawable.Drawable;
import android.os.AsyncTask;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.View.OnClickListener;
import android.view.ViewGroup;
import android.widget.Button;
import android.widget.CheckBox;
import android.widget.CompoundButton;
import android.widget.CompoundButton.OnCheckedChangeListener;
import android.widget.LinearLayout;
import android.widget.RelativeLayout;
import android.widget.SeekBar;
import android.widget.SeekBar.OnSeekBarChangeListener;
import android.widget.TextView;
import android.widget.Toast;

import com.epbitservices.unme.LoginNew;
import com.epbitservices.unme.LoginUsingFacebook;
import com.epbitservices.unme.R;
import com.epbitservices.unme.db.DatabaseHandler;
import com.epbitservices.unme.model.KeyValuePair;
import com.epbitservices.unme.model.PreferenceModel;
import com.epbitservices.unme.pojo.DeleteUserAccountData;
import com.epbitservices.unme.pojo.UpdatePrefrence;
import com.epbitservices.unme.utility.AppLog;
import com.epbitservices.unme.utility.ConnectionDetector;
import com.epbitservices.unme.utility.Constant;
import com.epbitservices.unme.utility.HttpRequest;
import com.epbitservices.unme.utility.JsonParser;
import com.epbitservices.unme.utility.SessionManager;
import com.epbitservices.unme.utility.Ultilities;
import com.epbitservices.unme.utility.Utility;
import com.facebook.LoggingBehaviors;
import com.facebook.Session;
import com.facebook.SessionState;
import com.facebook.Settings;
import com.flurry.android.FlurryAgent;
import com.google.gson.Gson;
import com.ranger.RangeBar;

public class SettingActivity extends Fragment implements OnClickListener {
	// private static boolean mDebugLog = true;
	// private static final String mDebugTag = "SettingActivity";
	private static final String TAG = "SettingActivity";
	private static final int THRESHOLD = 0;
	private SharedPreferences preferences;
	private String userSex;
	private Drawable drawable;
	private boolean flage;
	private RangeBar rangebar;;
	private SeekBar seeklitmitosearch;
	private int minAge, maxAge;
	private TextView maleTextview, femaleTextview, imTextview,
			ganderNameTextview, showmemaletextview, showmefemaltextview,
			limitotsearchvalue, showagetextview, maxage, agedeshtextview,
			showdistancetextview, distancevalue, MiTextview, kmTextview,
			minagevalue, showmetextivew, maleFemaleTextview,
			limitsearchtextview;
	private CheckBox maleChekbox, femaleChekbox;
	private Button contactButton, logoutButton, deleteaccount, update;
	private int usersexprefrence, usersex, radious;
	private boolean isDistanceUinitKm, ismaleselected, isfemalselected;
	private ProgressDialog mDialog;
	private String distanceunit;
	private int distanceunilt = 1;
	private RelativeLayout maletextviewparentlayout,
			femaletextviewparentlayout, MiTextviewparentlayout,
			kmTextviewparentLayout;
	SessionManager mSessionManager;
	private ConnectionDetector cd;	

	private Session.StatusCallback statusCallback = new SessionStatusCallback();

	@Override
	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		View view = inflater.inflate(R.layout.settingactivity, null);
		SharedPreferences prefs =getActivity().getSharedPreferences("mypreferences", 0); 

		
		cd = new ConnectionDetector(getActivity());
		if (!cd.isConnectingToInternet()) {
			Toast.makeText(getActivity(),R.string.no_network , Toast.LENGTH_SHORT)
					.show();
			return view;
		}
		initDataList(view);
		Settings.addLoggingBehavior(LoggingBehaviors.INCLUDE_ACCESS_TOKENS);
		Session session = Session.getActiveSession();

		if (session == null) {
			if (savedInstanceState != null) {
				session = Session.restoreSession(getActivity(), null,
						statusCallback, savedInstanceState);

			}
			if (session == null) {
				session = new Session(getActivity());

			}
			Session.setActiveSession(session);

			if (session.getState().equals(SessionState.CREATED_TOKEN_LOADED)) {

			}
		}

		rangebar.setTickCount(38);
		rangebar.setTickHeight(0);

		rangebar.setOnRangeBarChangeListener(new RangeBar.OnRangeBarChangeListener() {
			@Override
			public void onIndexChangeListener(RangeBar rangeBar,
					int leftThumbIndex, int rightThumbIndex) {

				
				minagevalue.setText((leftThumbIndex + 18) + "");
				maxage.setText((rightThumbIndex + 18) + "");
				minAge = leftThumbIndex + 18;
				maxAge = rightThumbIndex + 18;
				// leftIndexValue.setText("" + leftThumbIndex);
				// rightIndexValue.setText("" + rightThumbIndex);
			}
		});

		try {
			update.setOnClickListener(this);
//			logoutButton.setOnClickListener(this);
			MiTextviewparentlayout.setOnClickListener(this);
			kmTextviewparentLayout.setOnClickListener(this);
			// femaleChekbox.setOnClickListener(this);
			// / maleChekbox.setOnClickListener(this);
			maletextviewparentlayout.setOnClickListener(this);
			femaletextviewparentlayout.setOnClickListener(this);
			deleteaccount.setOnClickListener(this);
			contactButton.setOnClickListener(this);

			mSessionManager = new SessionManager(getActivity());
			Utility.showProcess(getActivity(), "Getting Data...");
			new Thread(new Runnable() {

				@Override
				public void run() {

					ArrayList<NameValuePair> keyValuePairs = new ArrayList<NameValuePair>();
					keyValuePairs.add(new KeyValuePair(
							Constant.KEY_FACEBOOK_ID, preferences.getString(
									Constant.FACEBOOK_ID, "")));
					HttpRequest httpRequest = new HttpRequest();
					try {
						String response = httpRequest.postData(
								Constant.preference_url, keyValuePairs);
						AppLog.Log(TAG, "preference Response:" + response);
						PreferenceModel prefData = JsonParser
								.parsePreferenceResponse(response);
						if (prefData.getErrFlag() == 0) {
							userSex = prefData.getSex() + "";
							minAge = prefData.getPrefLowerAge();
							maxAge = prefData.getPrefUpperAge();
							usersexprefrence = prefData.getPrefSex();

							mSessionManager.setUserHeigherAge("" + maxAge);
							mSessionManager.setUserLowerAge("" + minAge);
							mSessionManager.setDistaceUnit("Km");
							mSessionManager.setDistance(prefData
									.getPrefRadius());
							mSessionManager.setUserPrefSex(usersexprefrence
									+ "");
							mSessionManager.setUserSex(userSex);

							getActivity().runOnUiThread(new Runnable() {

								@Override
								public void run() {
									Utility.closeprocess(getActivity());
									setData();

								}
							});
						}
					} catch (Exception exception) {
						exception.printStackTrace();
					}
				}
			}).start();
			// userSex = mSessionManager.getUserSex();
			// // logDebug("onCreate userSex  " + userSex);
			// AppLog.Log(TAG, "onCreate userSex  " + userSex);
			// minAge = Integer.parseInt(mSessionManager.getUserLowerAge());
			// maxAge = Integer.parseInt(mSessionManager.getUserHeigherAge());
			// usersexprefrence = Integer.parseInt(mSessionManager
			// .getUserPrefSex());
			// logDebug("onCreate minAge  " + minAge);
			// logDebug("onCreate maxAge  " + maxAge);
			// AppLog.Log(TAG, "onCreate minAge  " + minAge);
			// AppLog.Log(TAG, "onCreate maxAge  " + maxAge);

		}

		catch (Exception e) {
			AppLog.Log(TAG, "onCreate   Exception  " + e);
		}
		// SharedPreferences preferences = PreferenceManager
		// .getDefaultSharedPreferences(getActivity());
		// chbJewish.setChecked(preferences
		// .getBoolean(Constant.PREF_JEWISH, false));

		return view;
	}

	@SuppressWarnings("deprecation")
	private void setData() {
		if(minAge==maxAge)
		{
			minAge=18;
			maxAge=48;
		}
		rangebar.setThumbIndices(minAge-18 , maxAge-18 );
		minagevalue.setText("" + minAge);
		maxage.setText("" + maxAge);
		

		// userSex.endsWith("male")

		if ((MainActivity.sex).equals("1")) {
			AppLog.Log(TAG, "onCreate selected   ");
			maletextviewparentlayout
			.setBackgroundDrawable(getResources().getDrawable(R.drawable.save_button_background));
			femaletextviewparentlayout
					.setBackgroundResource(R.drawable.selector_off);
			ganderNameTextview.setText(getResources().getString(
					R.string.maletextview));
		
//			maleTextview.setTextColor(Color.rgb(255, 255, 255));
//			femaleTextview.setTextColor(Color.rgb(153, 153, 153));
			usersex = 1;

			ismaleselected = true;
			isfemalselected = false;
		} else {
			AppLog.Log(TAG, "onCreate female selected   ");
			maletextviewparentlayout
					.setBackgroundResource(R.drawable.selector_off);
			// changing color
//			Bitmap bmp=BitmapFactory.decodeResource(getResources(), R.drawable.selector_on);
//			int [] allpixels = new int [ bmp.getHeight()*bmp.getWidth()];
//			bmp.getPixels(allpixels, 0, bmp.getWidth(), 0, 0, bmp.getWidth(),bmp.getHeight());
//			for(int i =0; i<bmp.getHeight()*bmp.getWidth();i++){
//
//				 if( allpixels[i] == Color.BLUE)
//				             allpixels[i] = MainActivity.navigation_color;
//				 }
//			bmp.setPixels(allpixels, 0, bmp.getWidth(), 0, 0, bmp.getWidth(), bmp.getHeight());
			//
			femaletextviewparentlayout
			.setBackgroundDrawable(getResources().getDrawable(R.drawable.save_button_background));

			ganderNameTextview.setText(getResources().getString(
					R.string.femaletextview));
//			femaleTextview.setTextColor(Color.rgb(255, 255, 255));
//			maleTextview.setTextColor(Color.rgb(153, 153, 153));
			usersex = 2;

			ismaleselected = false;
			isfemalselected = true;
		}

		seeklitmitosearch
				.setOnSeekBarChangeListener(new OnSeekBarChangeListener() {
					int progressChanged = 0;

					public void onProgressChanged(SeekBar seekBar,
							int progress, boolean fromUser) {
						radious = progress;
						AppLog.Log(TAG, "onProgressChanged  radious");
						limitotsearchvalue.setText("" + radious);
					}

					public void onStartTrackingTouch(SeekBar seekBar) {
					}

					public void onStopTrackingTouch(SeekBar seekBar) {

					}
				});
		if (mSessionManager.getDistaceUnit().equals("Km")) {
			kmTextviewparentLayout
					.setBackgroundResource(R.drawable.selector_on);
			MiTextviewparentlayout
					.setBackgroundResource(R.drawable.selector_off);

			isDistanceUinitKm = true;
			radious = mSessionManager.getDistance();
			distanceunit = "Km";
			distancevalue.setText("Km");
			distanceunilt = 1;

//			kmTextview.setTextColor(Color.rgb(255, 255, 255));
//			MiTextview.setTextColor(Color.rgb(153, 153, 153));
		} else {
			MiTextviewparentlayout
					.setBackgroundResource(R.drawable.selector_on);
			kmTextviewparentLayout
					.setBackgroundResource(R.drawable.selector_off);
			isDistanceUinitKm = false;
			radious = mSessionManager.getDistance();
			distanceunit = "Mi";
			distancevalue.setText("Mi");
			distanceunilt = 2;
//			MiTextview.setTextColor(Color.rgb(255, 255, 255));
//			kmTextview.setTextColor(Color.rgb(153, 153, 153));
		}

		AppLog.Log(TAG, "oncreate radious " + radious);
		seeklitmitosearch.setProgress(radious);

		limitotsearchvalue.setText("" + radious);

		Log.i("TAG", "user sex pref" + usersexprefrence);
		if (usersexprefrence == 3) {
			maleChekbox.setChecked(true);
			femaleChekbox.setChecked(true);
			maleFemaleTextview.setText("Male/Female");
		} else if (usersexprefrence == 2) {
			maleChekbox.setChecked(false);
			femaleChekbox.setChecked(true);
			maleFemaleTextview.setText("Female");
		} else if (usersexprefrence == 1) {
			maleChekbox.setChecked(true);
			femaleChekbox.setChecked(false);
			maleFemaleTextview.setText("Male");
		}

		maleChekbox.setOnCheckedChangeListener(new OnCheckedChangeListener() {

			@Override
			public void onCheckedChanged(CompoundButton buttonView,
					boolean isChecked) {
				AppLog.Log(
						TAG,
						"setOnCheckedChangeListener onCheckedChanged maleChekbox  maleChekbox isChecked "
								+ isChecked);
				AppLog.Log(
						TAG,
						"setOnCheckedChangeListener onCheckedChanged maleChekbox  femelcheckbox isChecked "
								+ femaleChekbox.isChecked());
				if (isChecked && femaleChekbox.isChecked()) {
					AppLog.Log(TAG,
							"setOnCheckedChangeListener onCheckedChanged  maleChekbox both selected ");
					maleFemaleTextview.setText("Male/Female");
					usersexprefrence = 3;
				} else if (isChecked) {
					AppLog.Log(TAG,
							"setOnCheckedChangeListener onCheckedChanged  maleChekbox male selected ");
					maleFemaleTextview.setText("Male");
					usersexprefrence = 1;
				}

				else if (femaleChekbox.isChecked()) {
					AppLog.Log(TAG,
							"setOnCheckedChangeListener onCheckedChanged maleChekbox  female selected ");
					maleFemaleTextview.setText("Female");
					usersexprefrence = 2;
				} else {
					femaleChekbox.setChecked(true);
					AppLog.Log(
							TAG,
							"setOnCheckedChangeListener onCheckedChanged maleChekbox  both not selecte selected ");
				}
			}
		});

		femaleChekbox.setOnCheckedChangeListener(new OnCheckedChangeListener() {

			@Override
			public void onCheckedChanged(CompoundButton buttonView,
					boolean isChecked) {
				AppLog.Log(
						TAG,
						"setOnCheckedChangeListener onCheckedChanged femaleChekbox  femaleChekbox isChecked "
								+ isChecked);
				AppLog.Log(
						TAG,
						"setOnCheckedChangeListener onCheckedChanged  femaleChekbox  maleChekbox isChecked "
								+ maleChekbox.isChecked());

				if (isChecked && maleChekbox.isChecked()) {
					AppLog.Log(TAG,
							"setOnCheckedChangeListener onCheckedChanged  femaleChekbox   both selected ");
					maleFemaleTextview.setText("Male/Female");
					usersexprefrence = 3;
				} else if (isChecked) {
					AppLog.Log(TAG,
							"setOnCheckedChangeListener onCheckedChanged  femaleChekbox  female selected ");
					maleFemaleTextview.setText("Female");
					usersexprefrence = 2;
				}

				else if (maleChekbox.isChecked()) {
					AppLog.Log(TAG,
							"setOnCheckedChangeListener onCheckedChanged femaleChekbox  male selected ");
					maleFemaleTextview.setText("Male");
					usersexprefrence = 1;
				} else {
					maleChekbox.setChecked(true);

					AppLog.Log(
							TAG,
							"setOnCheckedChangeListener onCheckedChanged femaleChekbox  both not selecte selected ");
				}
			}
		});
	}

	private void initDataList(View view) {
		preferences = PreferenceManager
				.getDefaultSharedPreferences(getActivity());
		imTextview = (TextView) view.findViewById(R.id.imTextview);

		maleTextview = (TextView) view.findViewById(R.id.maleTextview);
		rangebar = (RangeBar) view.findViewById(R.id.rangebar1);
		contactButton = (Button) view.findViewById(R.id.contactButton);
		contactButton.setBackgroundColor(MainActivity.navigation_color);
		update = (Button) view.findViewById(R.id.update);
		update.setBackgroundColor(MainActivity.navigation_color);
		maxage = (TextView) view.findViewById(R.id.maxage);
		minagevalue = (TextView) view.findViewById(R.id.minagevalue);
		agedeshtextview = (TextView) view.findViewById(R.id.agedeshtextview);

		limitotsearchvalue = (TextView) view
				.findViewById(R.id.limitotsearchvalue);

		ganderNameTextview = (TextView) view
				.findViewById(R.id.ganderNameTextview);
		femaleTextview = (TextView) view.findViewById(R.id.femaleTextview);
		ganderNameTextview = (TextView) view
				.findViewById(R.id.ganderNameTextview);

		showmetextivew = (TextView) view.findViewById(R.id.showmetextivew);
		maleFemaleTextview = (TextView) view
				.findViewById(R.id.maleFemaleTextview);
		showmemaletextview = (TextView) view
				.findViewById(R.id.showmemaletextview);
		showmefemaltextview = (TextView) view
				.findViewById(R.id.showmefemaltextview);
		maleChekbox = (CheckBox) view.findViewById(R.id.maleChekbox);
		femaleChekbox = (CheckBox) view.findViewById(R.id.femaleChekbox);
		limitsearchtextview = (TextView) view
				.findViewById(R.id.limitsearchtextview);
		seeklitmitosearch = (SeekBar) view.findViewById(R.id.seeklitmitosearch);
		//setting rangebar
		if ((MainActivity.sex).equals("1"))
				seeklitmitosearch.setThumb(getResources().getDrawable(R.drawable.slider_switch));
		else
			
			seeklitmitosearch.setThumb(getResources().getDrawable(R.drawable.slider_switch1));
				
				//
		showdistancetextview = (TextView) view
				.findViewById(R.id.showdistancetextview);
		distancevalue = (TextView) view.findViewById(R.id.distancevalue);
		MiTextview = (TextView) view.findViewById(R.id.MiTextview);
		kmTextview = (TextView) view.findViewById(R.id.kmTextview);

		maletextviewparentlayout = (RelativeLayout) view
				.findViewById(R.id.maletextviewparentlayout);
		femaletextviewparentlayout = (RelativeLayout) view
				.findViewById(R.id.femaletextviewparentlayout);
		MiTextviewparentlayout = (RelativeLayout) view
				.findViewById(R.id.MiTextviewparentlayout);
		kmTextviewparentLayout = (RelativeLayout) view
				.findViewById(R.id.kmTextviewparentLayout);

		showagetextview = (TextView) view.findViewById(R.id.showagetextview);

		Typeface HelveticaLTStd_Light = Typeface.createFromAsset(getActivity()
				.getAssets(), "fonts/HelveticaLTStd-Light.otf");
		Typeface HelveticaInseratLTStd_Roman = Typeface.createFromAsset(
				getActivity().getAssets(),
				"fonts/HelveticaInseratLTStd-Roman.otf");
//		imTextview.setTypeface(HelveticaLTStd_Light);
//		imTextview.setTextColor(Color.rgb(105, 105, 105));
//		ganderNameTextview.setTypeface(HelveticaInseratLTStd_Roman);
//		ganderNameTextview.setTextColor(Color.rgb(105, 105, 105));

//		maleTextview.setTypeface(HelveticaLTStd_Light);
//
//		showmetextivew.setTypeface(HelveticaLTStd_Light);
//		showmetextivew.setTextColor(Color.rgb(105, 105, 105));

//		maleFemaleTextview.setTypeface(HelveticaInseratLTStd_Roman);
//		maleFemaleTextview.setTextColor(Color.rgb(105, 105, 105));

//		showmemaletextview.setTypeface(HelveticaInseratLTStd_Roman);
//		showmemaletextview.setTextColor(Color.rgb(105, 105, 105));

//		showmefemaltextview.setTypeface(HelveticaInseratLTStd_Roman);
//		showmefemaltextview.setTextColor(Color.rgb(105, 105, 105));

//		limitsearchtextview.setTypeface(HelveticaLTStd_Light);
		limitsearchtextview.setTextColor(Color.rgb(105, 105, 105));

//		limitotsearchvalue.setTypeface(HelveticaInseratLTStd_Roman);
//		limitotsearchvalue.setTextColor(Color.rgb(105, 105, 105));

//		showagetextview.setTypeface(HelveticaLTStd_Light);
//		showagetextview.setTextColor(Color.rgb(105, 105, 105));

//		minagevalue.setTypeface(HelveticaInseratLTStd_Roman);
//		minagevalue.setTextColor(Color.rgb(105, 105, 105));

//		maxage.setTypeface(HelveticaInseratLTStd_Roman);
//		maxage.setTextColor(Color.rgb(105, 105, 105));

//		agedeshtextview.setTypeface(HelveticaInseratLTStd_Roman);
//		agedeshtextview.setTextColor(Color.rgb(105, 105, 105));

//		showdistancetextview.setTypeface(HelveticaLTStd_Light);
//		showdistancetextview.setTextColor(Color.rgb(105, 105, 105));

//		distancevalue.setTypeface(HelveticaInseratLTStd_Roman);
//		distancevalue.setTextColor(Color.rgb(105, 105, 105));

//		MiTextview.setTypeface(HelveticaLTStd_Light);
//		kmTextview.setTypeface(HelveticaLTStd_Light);

		deleteaccount = (Button) view.findViewById(R.id.deleteaccount);
		deleteaccount.setVisibility(View.GONE);

	}

	@SuppressWarnings("deprecation")
	@Override
	public void onClick(View v) {
		if (v.getId() == R.id.MiTextviewparentlayout) {
			if (isDistanceUinitKm) {
				isDistanceUinitKm = false;
				kmTextviewparentLayout
						.setBackgroundResource(R.drawable.selector_off);
				MiTextviewparentlayout
						.setBackgroundResource(R.drawable.selector_on);
				distanceunit = "Mi";
				distancevalue.setText(distanceunit);
				MiTextview.setTextColor(Color.rgb(255, 255, 255));
				kmTextview.setTextColor(Color.rgb(153, 153, 153));
			} else {

			}
		}
		if (v.getId() == R.id.kmTextviewparentLayout) {
			if (isDistanceUinitKm) {

			} else {
				kmTextviewparentLayout
						.setBackgroundResource(R.drawable.selector_on);
				MiTextviewparentlayout
						.setBackgroundResource(R.drawable.selector_off);
				distanceunit = "Km";
				distancevalue.setText(distanceunit);
				kmTextview.setTextColor(Color.rgb(255, 255, 255));
				MiTextview.setTextColor(Color.rgb(153, 153, 153));
				isDistanceUinitKm = true;
			}
		}
		if (v.getId() == R.id.maletextviewparentlayout) {
			if (ismaleselected) {

			} else {
				ganderNameTextview.setText(getResources().getString(
						R.string.maletextview));
				usersex = 1;
				maletextviewparentlayout
						.setBackgroundDrawable(getResources().getDrawable(R.drawable.save_button_background));
				femaletextviewparentlayout
						.setBackgroundResource(R.drawable.selector_off);
				maleTextview.setTextColor(Color.rgb(255, 255, 255));
				femaleTextview.setTextColor(Color.rgb(105, 105, 105));
				flage=true;
				ismaleselected = true;
			}
		}
		if (v.getId() == R.id.femaletextviewparentlayout) {
			if (ismaleselected) {
				ganderNameTextview.setText(getResources().getString(
						R.string.femaletextview));
				usersex = 2;
				flage=true;
				maletextviewparentlayout
						.setBackgroundResource(R.drawable.selector_off);
				;
				femaletextviewparentlayout
				.setBackgroundDrawable(getResources().getDrawable(R.drawable.save_button_background));
				femaleTextview.setTextColor(Color.rgb(255, 255, 255));
				maleTextview.setTextColor(Color.rgb(105, 105, 105));
				ismaleselected = false;

			} else {

			}
		}
		if (v.getId() == R.id.update) {
			updateUserPrefrence();
			if(flage){
			Intent in =new Intent(getActivity(),MainActivity.class);
			in.putExtra("sex", usersex);
			Log.d("setting gender", ""+usersex);
			
			startActivity(in);
			
			}
		}
//		if (v.getId() == R.id.logoutButton) {
//			logoutCurrentUser();
//		}
		if (v.getId() == R.id.contactButton) {
			Intent email = new Intent(Intent.ACTION_SEND/* Intent.ACTION_VIEW */);
			email.setType("message/rfc822");
			// email.putExtra(Intent.EXTRA_EMAIL,emailStrArray);
			email.putExtra(Intent.EXTRA_SUBJECT, "You & Me");
			email.putExtra(Intent.EXTRA_TEXT, "");
			email.putExtra(android.content.Intent.EXTRA_EMAIL,
					new String[] { "support@eprofitbooster.com" });
			startActivity(Intent.createChooser(email,
					"Choose an Email client :"));
		}
		if (v.getId() == R.id.deleteaccount) {
			delettCurrentUser();
		}
	}

	private void logoutCurrentUser() {
		// SessionManager mSessionManager = new SessionManager(getActivity());
		// String sessionToke = mSessionManager.getUserToken();
		// String deviceid = Ultilities.getDeviceId(getActivity());
		// String[] params = { sessionToke, deviceid };
		// new BackGroundTaskForLogout().execute(params);
		AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
		builder.setTitle("Logout");
		builder.setMessage("Are you sure you want to logout from this application?");
		builder.setCancelable(false);
		builder.setPositiveButton("Yes", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int id) {
				dialog.cancel();
				Editor editor = preferences.edit();
				editor.clear();
				editor.commit();
				DatabaseHandler handler = new DatabaseHandler(getActivity());
				handler.clearAllData();
				getActivity().finish();
				startActivity(new Intent(getActivity(), LoginNew.class));
			}
		});
		builder.setNegativeButton("No", new DialogInterface.OnClickListener() {
			public void onClick(DialogInterface dialog, int id) {
				dialog.cancel();
			}
		});
		//
		AlertDialog alert = builder.create();
		alert.show();

	}

	private void delettCurrentUser() {
		// SessionManager mSessionManager = new SessionManager(getActivity());
		// String sessionToke = mSessionManager.getUserToken();
		// String deviceid = Ultilities.getDeviceId(getActivity());
		String[] params = { preferences.getString(Constant.FACEBOOK_ID, "") };
		new BackGroundTaskForDeleteAccount().execute(params);
	}

	private class BackGroundTaskForDeleteAccount extends
			AsyncTask<String, Void, Void> {
		private String response;
		private boolean responseSuccess;
		private List<NameValuePair> deletuserAccountParameterList;
		private DeleteUserAccountData deleteUserAccountData;
		private Ultilities mUltilities = new Ultilities();

		@Override
		protected Void doInBackground(String... params) {
			deletuserAccountParameterList = mUltilities
					.getDeleteUserAccountParameter(params);
			AppLog.Log(TAG,
					"BackGroundTaskForDeleteAccount  deletuserAccountParameterList "
							+ deletuserAccountParameterList);
			response = mUltilities.makeHttpRequest(
					Constant.deleteUserAccount_url, Constant.methodeName,
					deletuserAccountParameterList);
			AppLog.Log(TAG, "BackGroundTaskForDeleteAccount  response "
					+ response);
			Gson gson = new Gson();
			deleteUserAccountData = gson.fromJson(response,
					DeleteUserAccountData.class);
			if (deleteUserAccountData.getErrFlag() == 0
					&& deleteUserAccountData.getErrNum() == 61) {
				Session session = Session.getActiveSession();
				AppLog.Log(TAG, "BackGroundTaskForLogout  session " + session);
				if (!session.isClosed()) {
					AppLog.Log(TAG,
							"BackGroundTaskForLogout  session not close need to cleaar  "
									+ session.getState());
					session.closeAndClearTokenInformation();
				} else {
					// nothing session already close no need to clear
				}

				// DatabaseHandler databaseHandler=new
				// DatabaseHandler(getActivity());
				// databaseHandler.deleteUserData();
			} else if (deleteUserAccountData.getErrFlag() == 1
					&& deleteUserAccountData.getErrNum() == 31) {
				Session session = Session.getActiveSession();
				AppLog.Log(TAG, "BackGroundTaskForLogout  session " + session);
				if (!session.isClosed()) {
					AppLog.Log(TAG,
							"BackGroundTaskForLogout  session not close need to cleaar  "
									+ session.getState());
					session.closeAndClearTokenInformation();

				} else {
					// nothing session already close no need to clear
				}
			}

			return null;
		}

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			try {
				mDialog = mUltilities.GetProcessDialog(getActivity());
				mDialog.setMessage("Please wait..");
				mDialog.setCancelable(true);
				mDialog.show();
			} catch (Exception e) {
				AppLog.Log(TAG,
						"BackGroundTaskForLogout onPreExecute Exception " + e);
			}
		}

		@Override
		protected void onPostExecute(java.lang.Void result) {
			super.onPostExecute(result);
			try {
				mDialog.dismiss();
				if (deleteUserAccountData.getErrFlag() == 0
						&& deleteUserAccountData.getErrNum() == 61) {
					// Intent intent = new Intent(Intent.ACTION_MAIN);
					// intent.addCategory(Intent.CATEGORY_HOME);
					// intent.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
					// startActivity(intent);
					// getActivity().finish();
					SessionManager mSessionManager = new SessionManager(
							getActivity());
					mSessionManager.logoutUser();
					Intent intent = new Intent(getActivity(),
							LoginUsingFacebook.class);
					intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
					startActivity(intent);
					getActivity().finish();
				} else if (deleteUserAccountData.getErrFlag() == 1
						&& deleteUserAccountData.getErrNum() == 62) {
					ErrorMessage(getString(R.string.alert), deleteUserAccountData.getErrMsg());
				} else if (deleteUserAccountData.getErrFlag() == 1
						&& deleteUserAccountData.getErrNum() == 31) {
					ErrorMessageInvalidSessionTOken(getString(R.string.alert),
							deleteUserAccountData.getErrMsg());
				} else {
					// some thing wrong is happend
				}

			} catch (Exception e) {
				AppLog.Log(TAG,
						"BackGroundTaskForLogout onPostExecute Exception " + e);

			}
		}
	}

	

	private void updateUserPrefrence() {
		SessionManager mSessionManager = new SessionManager(getActivity());
		String sessionToke = mSessionManager.getUserToken();
		String deviceid = Ultilities.getDeviceId(getActivity());
		String loweragePrefrence = "" + minAge;
		String heigherAge = "" + maxAge;
		String sexPrefrence = "" + usersexprefrence;
		String selectedusersex = "" + usersex;
		String userSelectedRadius = "" + radious;
		String[] params = { sessionToke, deviceid, selectedusersex,
				sexPrefrence, loweragePrefrence, heigherAge,
				userSelectedRadius, "" + distanceunilt,
				preferences.getString(Constant.FACEBOOK_ID, "") };
		new BackgroundTaskForUpdatePrefrence().execute(params);
	}

	private class BackgroundTaskForUpdatePrefrence extends
			AsyncTask<String, Void, Void> {
		private String response;
		private boolean responseSuccess;
		private List<NameValuePair> prefrenceUpdateParameter;
		private UpdatePrefrence mUpdatePrefrence;
		private Ultilities mUltilities = new Ultilities();
		private String loweragePrefrence, heigherAge, sexPrefrence,
				selectedusersex, userSelectedRadius;

		@Override
		protected Void doInBackground(String... params) {
			try {
				selectedusersex = params[2];
				sexPrefrence = params[3];
				loweragePrefrence = params[4];
				heigherAge = params[5];
				userSelectedRadius = params[6];

				prefrenceUpdateParameter = mUltilities
						.getUserPrefrenceParameter(params);
				response = mUltilities.makeHttpRequest(
						Constant.updatePrefrence_url, Constant.methodeName,
						prefrenceUpdateParameter);
				AppLog.Log(TAG,
						"BackgroundTaskForUpdatePrefrence doInBackground  response "
								+ response);
				Gson gson = new Gson();
				mUpdatePrefrence = gson.fromJson(response,
						UpdatePrefrence.class);
			} catch (Exception e) {
				AppLog.Log(TAG,
						"BackgroundTaskForUpdatePrefrence doInBackground  Exception "
								+ e);
			}

			return null;
		}

		@Override
		protected void onPostExecute(Void result) {
			super.onPostExecute(result);

			try {
				mDialog.dismiss();
				if (mUpdatePrefrence.getErrFlag() == 0
						&& mUpdatePrefrence.getErrNum() == 13) {
					SessionManager mSessionManager = new SessionManager(
							getActivity());
					mSessionManager.setDistance(Integer
							.parseInt(userSelectedRadius));
					mSessionManager.setUserHeigherAge(heigherAge);
					mSessionManager.setUserLowerAge(loweragePrefrence);

					mSessionManager.setUserSex(selectedusersex);
					mSessionManager.setUserPrefSex(sexPrefrence);
					mSessionManager.setDistaceUnit(distanceunit);

					Toast.makeText(getActivity(), mUpdatePrefrence.getErrMsg(),
							Toast.LENGTH_SHORT).show();
					// "Preferences updated successfully."

				} else if (mUpdatePrefrence.getErrFlag() == 1
						&& mUpdatePrefrence.getErrNum() == 14) {
					// Change any preferences to update
					mDialog.dismiss();
					ErrorMessage(getString(R.string.alert), mUpdatePrefrence.getErrMsg());
				} else {
					mDialog.dismiss();
					ErrorMessage(getString(R.string.alert),
							getString(R.string.unable_to_process));
				}

			} catch (Exception e) {
				AppLog.Log(TAG,
						" BackgroundTaskForUpdatePrefrence onPostExecute Exception "
								+ e);
			}

			/*
			 * Error: { "errNum": "14", "errFlag": "1", "errMsg":
			 * "Change any preferences to update." }
			 * 
			 * Success: { "errNum": "13", "errFlag": "0", "errMsg":
			 * "Preferences updated successfully." }
			 */

		}

		@Override
		protected void onPreExecute() {
			super.onPreExecute();
			mDialog = mUltilities.GetProcessDialog(getActivity());
			mDialog.setMessage(getString(R.string.please_wait));
			mDialog.setCancelable(true);
			mDialog.show();
		}

	}

	private void ErrorMessage(String title, String message) {
		AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
		builder.setTitle(title);
		builder.setMessage(message);
		builder.setPositiveButton(
				getResources().getString(R.string.okbuttontext),
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

	private void ErrorMessageInvalidSessionTOken(String title, String message) {
		AlertDialog.Builder builder = new AlertDialog.Builder(getActivity());
		builder.setTitle(title);
		builder.setMessage(message);
		builder.setPositiveButton(
				getResources().getString(R.string.okbuttontext),
				new DialogInterface.OnClickListener() {
					@Override
					public void onClick(DialogInterface dialog, int which) {
						SessionManager mSessionManager = new SessionManager(
								getActivity());
						mSessionManager.logoutUser();
						Intent intent = new Intent(getActivity(),
								LoginUsingFacebook.class);
						intent.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
						startActivity(intent);
						getActivity().finish();
						dialog.dismiss();
					}
				});

		AlertDialog alert = builder.create();
		alert.setCancelable(false);
		alert.show();
	}

	private class SessionStatusCallback implements Session.StatusCallback {
		@Override
		public void call(Session session, SessionState state,
				Exception exception) {
			// updateView();
		}
	}

	@Override
	public void onStart() {
		super.onStart();
		if (!cd.isConnectingToInternet()) {
			Toast.makeText(getActivity(), R.string.no_network, Toast.LENGTH_SHORT)
					.show();
			return;
		}
		Session.getActiveSession().addCallback(statusCallback);
		FlurryAgent.onStartSession(getActivity(), Constant.flurryKey);
	}

	@Override
	public void onStop() {
		super.onStop();
		Session.getActiveSession().removeCallback(statusCallback);
		FlurryAgent.onEndSession(getActivity());
	}

	@Override
	public void onActivityResult(int requestCode, int resultCode, Intent data) {
		super.onActivityResult(requestCode, resultCode, data);
		Session.getActiveSession().onActivityResult(getActivity(), requestCode,
				resultCode, data);
	}

	@Override
	public void onSaveInstanceState(Bundle outState) {
		super.onSaveInstanceState(outState);
		Session session = Session.getActiveSession();
		Session.saveSession(session, outState);
	}
	
	public void makeChangegForLayoutClick(LinearLayout layout,int gender){
		
		
		
		
		
		
	}

	/*
	 * @Override protected void onSaveInstanceState(Bundle outState) {
	 * super.onSaveInstanceState(outState); Session session =
	 * Session.getActiveSession(); Session.saveSession(session, outState); }
	 * 
	 */
	
}
