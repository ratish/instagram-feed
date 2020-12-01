# Steps to generate Instagram Access Token to access Basic Instagram API

Reference: https://developers.facebook.com/docs/instagram-basic-display-api/getting-started

## Step 1: Create a Facebook App

1. Go to developers.facebook.com
2. Click **My Apps** > Create a new app.
   ![Create new app](https:////i.imgur.com/RdMKZRu.png)
3. In the App Dashboard, go to Settings > Basic > Click Add Platform at the bottom of the page.
   ![App Dashboard](https://scontent-dfw5-1.xx.fbcdn.net/v/t39.2365-6/72141044_475195150002972_921159971188506624_n.png?_nc_cat=103&_nc_sid=ad8a9d&_nc_ohc=-oaQpZtjTc0AX_3hTN5&_nc_ht=scontent-dfw5-1.xx&oh=926c05a77648fbc3dbc07c4599eae813&oe=5E9B529A)
4. Choose **Website**, add *https://www.mywebsite.com/* as the Site URL and save.
   ![Website Site URL](https://scontent-dfw5-1.xx.fbcdn.net/v/t39.2365-6/72291908_391135508232420_8026274968247468032_n.png?_nc_cat=111&_nc_sid=ad8a9d&_nc_ohc=3qUBkCl1048AX96zHgR&_nc_ht=scontent-dfw5-1.xx&oh=185564c7af900b92ae9e4720f4dd6b70&oe=5E987BC8)

## Step 2: Configure Instagram Basic Display

5. Click Products > Instagram product > Set Up.
   ![Products Set Up](https://scontent-dfw5-2.xx.fbcdn.net/v/t39.2365-6/72282554_751755955273916_2109774612530200576_n.png?_nc_cat=107&_nc_sid=ad8a9d&_nc_ohc=c0VvL8eSP1AAX9EJYjb&_nc_ht=scontent-dfw5-2.xx&oh=933d0f376cf26f26bf01e8a910008078&oe=5E9A8C5F)
6. Click Basic Display > Create New App (at the bottom of the page).
   ![Create New App](https://scontent-dfw5-2.xx.fbcdn.net/v/t39.2365-6/72133609_2372753246311211_7775884782981873664_n.png?_nc_cat=102&_nc_sid=ad8a9d&_nc_ohc=oEAj1xG-XQQAX8ihFKz&_nc_ht=scontent-dfw5-2.xx&oh=4c7f7643879b62a6d4cceed41f31532d&oe=5E99BA3A)
7. In the form, enter the fields as below and save changes

-   Display Name: Name of the Facebook App created (Sample-IGAPP)
-   Valid OAuth Redirect URIs: https://www.mywebsite.com/ [Do not miss the / at the end of the URI]
-   Deauthorize Callback URL: https://www.mywebsite.com/
-   Data Deletion Request Callback URL: https://www.mywebsite.com/

## Step 3: Add an Instagram Test User

8. Add an Instagram Test User by going to Roles > Roles > Add Instagram Testers (in the Instagram Testers section)
   ![Add Instagram Test User](https://scontent-dfw5-1.xx.fbcdn.net/v/t39.2365-6/72372046_2983500408542204_4876523180891570176_n.png?_nc_cat=109&_nc_sid=ad8a9d&_nc_ohc=KrynjSkMIIwAX8-gwTB&_nc_ht=scontent-dfw5-1.xx&oh=8aaeee19e3c376d2ae6d088f98a55677&oe=5E9A35DE)
9. Enter Instagram account username, for e.g. MY_INSTAGRAM_ID and click submit to send the invitation.
10. Login to the Instagram account that you just sent the invitation.
11. Go to (Profile Icon) > Edit Profile > Apps and Websites > Tester Invites and accept the invitation.
    ![Tester Invite](https://scontent-dfw5-1.xx.fbcdn.net/v/t39.2365-6/72348335_408099509903108_826206606575271936_n.png?_nc_cat=103&_nc_sid=ad8a9d&_nc_ohc=pGJTA2941m0AX_JjNBA&_nc_ht=scontent-dfw5-1.xx&oh=87bbeb2ac59c833d8f6c403c77caae09&oe=5E9B1A6C)

## Step 4: Authenticate the Test User

12. On your Facebook Developer Account, go to App Dashboard > Products > Instagram > Basic Display > Instagram App ID

13. Open a new browser tab and open the link after updating the client id and redirect uri:

```
https://api.instagram.com/oauth/authorize?client_id={Instagram App ID}&redirect_uri={Valid OAuth Redirect URI}&scope=user_profile,user_media&response_type=code
```

**For example:**

```
https://api.instagram.com/oauth/authorize?client_id=240139837162542&redirect_uri=https://www.mywebsite.com/&scope=user_profile,user_media&response_type=code
```

14. You should now see an Authorization Window that display the Instragram User's name and the App's name and permission details requested by the app.
    ![Authorize Window](https://scontent-dfw5-1.xx.fbcdn.net/v/t39.2365-6/73104138_383070672579531_6594576748594069504_n.png?_nc_cat=110&_nc_sid=ad8a9d&_nc_ohc=2DS5ayZp1J8AX_BVq8u&_nc_ht=scontent-dfw5-1.xx&oh=3f70b22f3500569953fcfe307c5e45f7&oe=5E9AB6F4)

15. Click Authorize button and the page should redirect to the redirect URI you included in the previous steps (https://www.mywebsite.com/)

16. The redirected page should include an authorization code at the end of the URL with _code_ parameter and \_#\_\_ characters.

```
https://www.mywebsite.com/?code=AQCpFnU...#_
```

17. Copy the code value without the \_#\_\_. This is the Authorication code that will be used to obtain token. The Authorization code will expire in an hour.

```
Authorization code = AQCpFnU...
```

## Step 5: Exchange the Code for a Token

18. Run a CURL command in your terminal window as :

```
curl -X POST \
  https://api.instagram.com/oauth/access_token \
  -F client_id={app-id} \
  -F client_secret={app-secret} \
  -F grant_type=authorization_code \
  -F redirect_uri={redirect-uri} \
  -F code={code}
```

The following values can be obtained from _App Dashboard > Products > Instagram > Basic Display_

`app-id = Instagram App ID`

`app-secret = Instagram App Secret`

`redirect-uri = https://www.mywebsite.com/`

---

`code = Authorization code obtained from previous step`

**For example:**

```
curl -X POST \
  https://api.instagram.com/oauth/access_token \
  -F client_id=240139... \
  -F client_secret=143ef0... \
  -F grant_type=authorization_code \
  -F redirect_uri=https://www.mywebsite.com/ \
  -F code=AQCpFnU...
```

19. Once the CURL command is run successfully, a similar output is expected.

```
{
    "access_token": "IGQVJYaUNsMW...",
    "user_id": 17843333444418436
}
```

The access token obtained is a short lived token and will expire in an hour.

## Step 6: Query the User Node (optional step)

20. In order to see if the access token obtained from the previous step is working, run the following CURL command:

```
curl -X GET \
  'https://graph.instagram.com/me?fields=id,username&access_token=IGQVJYaUNsMW...'
```

or run the alternate command:

```
curl -X GET \
  'https://graph.instagram.com/{user-id}?fields=id,username&access_token={access-token}'
```

Once the command runs, the following output is expected:

```
{
  "id": "17843333444418436",
  "username": "MY_INSTAGRAM_ID"
}
```

## Step 7: Obtain Long Lived Access Token

The access token obtained in the previous step is short lived and expires in an hour. In order to extend the expiration of the access token we must obtain long lived access token. The long lived access token expires in 60 days and can be refreshed after 24 hours once it is created and before the 60 day. We have to use the short lived access token to obtain the long lived access token.

21. Run the following CURL command to get the long lived access token:

```
curl -i -X GET "https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret={instagram-app-secret}
  &access_token={short-lived-access-token}"
```

` short-lived-access-token = short lived access token must not be expired`

` instagram-app-secret = App Dashboard > Products > Instagram > Basic Display > Instagram App Secret`

**For example:**

```
curl -i -X GET "https://graph.instagram.com/access_token?grant_type=ig_exchange_token&client_secret=240139...&access_token=IGQVJYaUNsMW..."
```

The following output is expected:

```
{
    "access_token":"{long-lived-access-token}",
    "token_type":"bearer",
    "expires_in":5183906 //Number of seconds until token expires
}
```

## Step 8: Refresh Long Lived Access Token (optional)

The long lived access token can be refreshed once it is 24 hours old and has not expired. The refreshed access token will expire in 60 days and can be refreshed before it expires.

22. To refresh the long lived access token:

```
curl -i -X GET "https://graph.instagram.com/refresh_access_token?grant_type=ig_refresh_token&access_token={long-lived-access-token}"
```

The following output is expected:

```
{
  "access_token":"{long-lived-user-access-token}",
  "token_type": "bearer",
  "expires_in": 5183944 // Number of seconds until token expires
}
```

## Step 9: Save Long Lived Access Token

23. Copy the long lived access token and save it to a file with the same name as the instragram account.

**For example:** `/usr2/phpincludes/instagram_app/tokenfilename`
The file should have the following file permissions:

`-rwxrw-r-x 1 root apache 149 Mar 19 19:48 tokenfilename`

```
chgrp apache tokenfilename
chmod 765 tokenfilename
```

We will be referencing this file in our PHP file to obtain the instagram feed.
