package com.android.slidingmenu;

import java.util.ArrayList;
import java.util.List;

import org.apache.http.NameValuePair;

import android.app.Activity;
import android.app.ProgressDialog;
import android.content.Context;
import android.content.SharedPreferences;
import android.content.SharedPreferences.Editor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.graphics.Canvas;
import android.graphics.Typeface;
import android.os.Bundle;
import android.preference.PreferenceManager;
import android.support.v4.app.Fragment;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemSelectedListener;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

import com.androidquery.AQuery;
import com.androidquery.callback.ImageOptions;
import com.epbitservices.unme.R;
import com.epbitservices.unme.model.KeyValuePair;
import com.epbitservices.unme.model.ProfileImageModel;
import com.epbitservices.unme.utility.AppLog;
import com.epbitservices.unme.utility.ConnectionDetector;
import com.epbitservices.unme.utility.Constant;
import com.epbitservices.unme.utility.ExtendedGallery;
import com.epbitservices.unme.utility.HttpRequest;
import com.epbitservices.unme.utility.JsonParser;
import com.epbitservices.unme.utility.ScalingUtilities;
import com.epbitservices.unme.utility.Ultilities;
import com.epbitservices.unme.utility.Utility;

public class UserProfile extends Fragment {

	private static final String TAG = "UserProfileFragment";
	private ExtendedGallery imageExtendedGallery;
	private ArrayList<String> imageList;
	private ImageAdapterForGellary mAdapterForGellary;
	private LinearLayout count_layout;
	private ImageView imageViewThumb;
	private int count;
	private TextView[] page_text;
	private TextView usernametextivew, ueragetextviw, aboutuserTextview,
			userboutTextview, userStatus;
	private LinearLayout userAboutLayout;
	private ProgressDialog mDialog;
	private int[] imageHeightandWIdth;
	private ConnectionDetector cd;
	private SharedPreferences preferences;
	private Bitmap frame;
	private int usernameLength;
	private Editor editor;

	@Override
	public View getView() {
		return super.getView();
	}

	@Override
	public View onCreateView(LayoutInflater inflater, ViewGroup container,
			Bundle savedInstanceState) {
		View view = inflater.inflate(R.layout.fragment_layout2, null);
         
		preferences = PreferenceManager
				.getDefaultSharedPreferences(getActivity());
		editor = preferences.edit();
		Ultilities ultilities = new Ultilities();
		Typeface HelveticaInseratLTStd_Roman = Typeface.createFromAsset(
				getActivity().getAssets(),
				"fonts/HelveticaInseratLTStd-Roman.otf");
		Typeface HelveticaLTStd_Light = Typeface.createFromAsset(getActivity()
				.getAssets(), "fonts/HelveticaLTStd-Light.otf");
		imageHeightandWIdth = ultilities
				.getImageHeightAndWidthForProfileGellary(getActivity());

		imageExtendedGallery = (ExtendedGallery) view
				.findViewById(R.id.imageExtendedGallery);
		userboutTextview = (TextView) view.findViewById(R.id.userboutTextview);
		usernametextivew = (TextView) view.findViewById(R.id.usernametextivew);
		ueragetextviw = (TextView) view.findViewById(R.id.ueragetextviw);
		count_layout = (LinearLayout) view.findViewById(R.id.image_count);
		
		aboutuserTextview = (TextView) view
				.findViewById(R.id.aboutuserTextview);
		userAboutLayout = (LinearLayout) view
				.findViewById(R.id.userAboutLayout);
		userAboutLayout.setVisibility(View.GONE);
		userStatus = ((TextView) view.findViewById(R.id.userStatustextView));
		if (preferences.getInt(Constant.PREF_USER_AGE, 0) != 0) {
	       usernameLength=preferences.getString(
					Constant.PREF_FIRST_NAME, "").length();
			usernametextivew.setText(preferences.getString(
					Constant.PREF_FIRST_NAME, "")
					+ " "
					+ preferences.getString(Constant.PREF_LAST_NAME, "")
					+ "  "
					+ preferences.getInt(Constant.PREF_USER_AGE, 0));
		} else {

		}

		imageList = new ArrayList<String>();
		mAdapterForGellary = new ImageAdapterForGellary(getActivity(),
				imageList);

		usernametextivew.setTypeface(HelveticaInseratLTStd_Roman);
		ueragetextviw.setTypeface(HelveticaLTStd_Light);
		userboutTextview.setTypeface(HelveticaInseratLTStd_Roman);
		aboutuserTextview.setTypeface(HelveticaInseratLTStd_Roman);
		imageExtendedGallery.setAdapter(mAdapterForGellary);
		
		cd = new ConnectionDetector(getActivity());
		if (cd.isConnectingToInternet()) {
			getProfileImages();
		} else {
			Toast.makeText(getActivity(), R.string.no_network, Toast.LENGTH_SHORT)
					.show();
		}
		//setting profile pick
//		setProfilePick(imageViewThumb);
		return view;
	}

	private void getProfileImages() {
		Utility.showProcess(getActivity(), getString(R.string.getting_image));
		final HttpRequest httpRequest = new HttpRequest();
		final List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>();
		nameValuePairs.add(new KeyValuePair(Constant.KEY_FACEBOOK_ID,
				preferences.getString(Constant.FACEBOOK_ID, "")));
		new Thread(new Runnable() {
			@Override
			public void run() {
				String json;
				try {
					json = httpRequest.postData(Constant.get_user_pro_pic,
							nameValuePairs);
					AppLog.Log(TAG, "Image json:" + json);
					ArrayList<ProfileImageModel> List = JsonParser
							.parseProfileImageData(json);
					AppLog.Log(TAG, "Return Image Size:" + List.size());
					SetListIntoPref(List);

					getActivity().runOnUiThread(new Runnable() {
						@Override
						public void run() {
							imageList = getImagesFromPref();
							setAdapterForGallery(imageList);
							Utility.closeprocess(getActivity());
//                          setProfilePick(imageViewThumb);    
						}
					});
				} catch (Exception e) {
					e.printStackTrace();
				}

			}

		}).start();
	}

	@Override
	public void onResume() {
		super.onResume();
		if (!preferences.getString(Constant.PREF_USER_STATUS, "").equals("")) {
			userStatus.setText(" :  "
					+ preferences.getString(Constant.PREF_USER_STATUS, ""));
		} else {
			userStatus.setText(" :  N/A");
		}
		preferences.getString(Constant.PREF_USER_ABOUT, "");
		imageList = getImagesFromPref();
		setAdapterForGallery(imageList);

	}

	private void setAdapterForGallery(ArrayList<String> List) {
		count = 0;
		page_text = null;
		mAdapterForGellary.notifyDataSetChanged();
		count = List.size();
		AppLog.Log(TAG, "List Size:" + count);
		page_text = new TextView[count];
		count_layout.removeAllViews();
		for (int i = 0; i < count; i++) {
			page_text[i] = new TextView(getActivity());
			page_text[i].setText(".");
			page_text[i].setTextSize(16);
			page_text[i].setTypeface(null, Typeface.BOLD);
			page_text[i].setTextColor(android.graphics.Color.GRAY);
			count_layout.addView(page_text[i]);
		}
		imageExtendedGallery
				.setOnItemSelectedListener(new OnItemSelectedListener() {

					@Override
					public void onItemSelected(AdapterView<?> parent,
							View view, int pos, long id) {

						for (int i = 0; i < count; i++) {
							page_text[i]
									.setTextColor(android.graphics.Color.GRAY);
						}
						page_text[pos]
								.setTextColor(android.graphics.Color.LTGRAY);
					}

					@Override
					public void onNothingSelected(AdapterView<?> arg0) {
					}
				});

	}

	protected void SetListIntoPref(ArrayList<ProfileImageModel> List) {
		if (List.size() > 0) {
			for (int i = 0; i < List.size(); i++) {
				final ProfileImageModel imageModel = List.get(i);
				int imageIndex = imageModel.getIndexId();
				switch (imageIndex) {
				case 0:
					editor.putString(Constant.PREF_PROFILE_IMAGE_ONE,
							imageModel.getImageUrl());
					editor.commit();
					break;
				case 1:
					editor.putString(Constant.PREF_PROFILE_IMAGE_TWO,
							imageModel.getImageUrl());
					editor.commit();
					break;
				case 2:
					editor.putString(Constant.PREF_PROFILE_IMAGE_THREE,
							imageModel.getImageUrl());
					editor.commit();
					break;
				case 3:
					editor.putString(Constant.PREF_PROFILE_IMAGE_FOUR,
							imageModel.getImageUrl());
					editor.commit();
					break;
				case 4:
					editor.putString(Constant.PREF_PROFILE_IMAGE_FIVE,
							imageModel.getImageUrl());
					editor.commit();
					break;
				case 5:
					editor.putString(Constant.PREF_PROFILE_IMAGE_SIX,
							imageModel.getImageUrl());
					editor.commit();
					break;
				default:
					break;
				}
			}

		}

	}

	private ArrayList<String> getImagesFromPref() {
		String photoOne = preferences.getString(
				Constant.PREF_PROFILE_IMAGE_ONE, null);
		String photoTwo = preferences.getString(
				Constant.PREF_PROFILE_IMAGE_TWO, null);
		String photoThree = preferences.getString(
				Constant.PREF_PROFILE_IMAGE_THREE, null);
		String photoFour = preferences.getString(
				Constant.PREF_PROFILE_IMAGE_FOUR, null);
		String photoFive = preferences.getString(
				Constant.PREF_PROFILE_IMAGE_FIVE, null);
		String photoSix = preferences.getString(
				Constant.PREF_PROFILE_IMAGE_SIX, null);
		imageList.clear();
		if (photoOne != null) {
			imageList.add(photoOne);
		}
		if (photoTwo != null) {
			imageList.add(photoTwo);
		}
		if (photoThree != null) {
			imageList.add(photoThree);
		}
		if (photoFour != null) {
			imageList.add(photoFour);
		}
		if (photoFive != null) {
			imageList.add(photoFive);
		}
		if (photoSix != null) {
			imageList.add(photoSix);
		}
		return imageList;

	}

	@Override
	public void onPause() {
		super.onPause();
		if (mDialog != null) {
			mDialog.dismiss();
		}
	}

	private class ImageAdapterForGellary extends ArrayAdapter<String> {

		Activity mActivity = getActivity();
		private LayoutInflater mInflater;
		AQuery aQuery;
		private ImageOptions options;

		public ImageAdapterForGellary(Context context, List<String> objects) {
			super(context, R.layout.galleritem, objects);
			mInflater = (LayoutInflater) mActivity
					.getSystemService(Context.LAYOUT_INFLATER_SERVICE);
			Log.i(TAG, "Profile image list size:" + objects.size());
			options = new ImageOptions();
			options.memCache = true;
			options.fileCache = true;
			options.animation = AQuery.FADE_IN;
		}

		@Override
		public int getCount() {
			return super.getCount();
		}

		@Override
		public String getItem(int position) {
			return super.getItem(position);
		}

		@Override
		public View getView(int position, View convertView, ViewGroup parent) {
			ViewHolder holder;
			if (convertView == null) {

				holder = new ViewHolder();
				convertView = mInflater.inflate(R.layout.galleritem, null);
				aQuery = new AQuery(convertView);
				holder.imageview = (ImageView) convertView
						.findViewById(R.id.thumbImage);
				imageViewThumb=holder.imageview;
				// holder.mProgressBar = (ProgressBar) convertView
				// .findViewById(R.id.pbGalleryItemImage);
				convertView.setTag(holder);
				//setting image
				try{
//				setProfilePick(holder.imageview);
				}catch(Exception e){Log.d("profile image", ""+e);}
			} else {
				holder = (ViewHolder) convertView.getTag();
			}
			// holder.mProgressBar.setId(position);
			holder.imageview.setId(position);
			if (getItem(position) != null) {
				// holder.mProgressBar.setVisibility(View.GONE);
				// holder.imageview.setImageBitmap(getItem(position).getmBitmap()
				aQuery.id(holder.imageview).image(getItem(position), options)
						.progress(R.id.pbGalleryItemImage);
				
				// /*
				// * Bitmap. createScaledBitmap ( getItem ( position ).
				// getmBitmap
				// * (), imageheightandWidth [1], imageheightandWidth [0], false
				// )
				// */);
			} else {
				Log.i(TAG, "image bitmap is null");
			}
			return convertView;
		}

		class ViewHolder {
			ImageView imageview;
			// ProgressBar mProgressBar;
		}
	}
	private void setProfilePick(final ImageView userProfilImage) {
		final Ultilities mUltilities = new Ultilities();

		// File appDirectory;
		// File _picDir;
		// File myimgFile;

		// try {

		// appDirectory =
		// mUltilities.createAppDirectoy(getResources().getString(R.string.appdirectory));
		// _picDir = new File(appDirectory,
		// getResources().getString(R.string.imagedirectory));
		// myimgFile= new File(_picDir,
		// getResources().getString(R.string.imagefilename)+"0.jpg");

		// DatabaseHandler mdaDatabaseHandler = new DatabaseHandler(this);
		// String imageOrderArray[] = { "1" };
		// ArrayList<ImageDetail> imagelist = mdaDatabaseHandler
		// .getImageDetailByImageOrder(imageOrderArray);
		// if (imagelist != null && imagelist.size() > 0) {
		// Bitmap bitmapimage = mUltilities.showImage/*
		// * setImageToImageViewBitmapFactory
		// * .decodeFiledecodeFile
		// */(imagelist.get(0)
		// .getSdcardpath());
		new Thread(new Runnable() {

			@Override
			public void run() {
				final Bitmap bitmapimage = Utility.getBitmapFromURL(preferences
						.getString(Constant.PREF_PROFILE_IMAGE_ONE, ""));
				
			getActivity().runOnUiThread(new Runnable() {

					@Override
					public void run() {
						AppLog.Log(
								TAG,
								"Profile Image Url:"
										+ preferences
												.getString(
														Constant.PREF_PROFILE_IMAGE_ONE,
														""));
						Bitmap frame = BitmapFactory.decodeResource(getResources(),R.drawable.frame);
						
						ScalingUtilities mScalingUtilities = new ScalingUtilities();
						Bitmap userimage=overlay(bitmapimage,frame);
						userProfilImage.setImageBitmap(userimage);
//						Bitmap mBitmap = null;
//						if (bitmapimage != null) {
//							cropedBitmap = mScalingUtilities
//									.createScaledBitmap(bitmapimage, 150, 150,
//											ScalingLogic.FIT);
//							bitmapimage.recycle();
//							mBitmap = mUltilities.getCircleBitmap(cropedBitmap,
//									1);
//							cropedBitmap.recycle();
//							userProfilImage.setImageBitmap(mBitmap);
//							// aQuery.id(userProfilImage).image(mBitmap);
//						} else {
//						}

					}
				});

			}
		}).start();

		// } else {
		//
		// }

		// } catch (Exception e) {
		// e.printStackTrace();
		// // ImageView[] params = { userProfilImage };
		// // new
		// // BackGroundTaskForDownloadProfileImageIfUseDeletedFormDirectory()
		// // .execute(params);
		// }

	}
	public static Bitmap overlay(Bitmap bmp1, Bitmap bmp2) {
        Bitmap bmOverlay = Bitmap.createBitmap(bmp1.getWidth(), bmp1.getHeight(), bmp1.getConfig());
        Canvas canvas = new Canvas(bmOverlay);
        canvas.drawBitmap(bmp1, 0,0, null);
        canvas.drawBitmap(bmp2, 0, 0, null);
        return bmOverlay;
    }
}
