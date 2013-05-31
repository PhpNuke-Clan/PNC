<?php

/*********************************************************************************/
/* CNB Your Account: An Advanced User Management System for phpnuke     		*/
/* ============================================                         		*/
/*                                                                      		*/
/* Copyright (c) 2004 by Comunidade PHP Nuke Brasil                     		*/
/* http://dev.phpnuke.org.br & http://www.phpnuke.org.br                		*/
/*                                                                      		*/
/* Contact author: escudero@phpnuke.org.br                              		*/
/* International Support Forum: http://ravenphpscripts.com/forum76.html 		*/
/*                                                                      		*/
/* This program is free software. You can redistribute it and/or modify 		*/
/* it under the terms of the GNU General Public License as published by 		*/
/* the Free Software Foundation; either version 2 of the License.       		*/
/*                                                                      		*/
/*********************************************************************************/
/* CNB Your Account it the official successor of NSN Your Account by Bob Marion	*/
/*********************************************************************************/

/********************************************************/
/* T�rk�e �evirmeni: Selim "MaXCoDeR" �umlu             */
/* Mail:webmaster@pcnet.com.tr                          */
/* URL: http://www.turknuke.com                         */
/********************************************************/
/* CNBYA �evirmeni : Emre "ZaLeX" YILDIRIM              */
/* ->MaXCoDeR'�n baz� �evirmeleri de�i�tirildi          */
/* ->CNBYA i�in gerekli �evirmeler yap�ld�              */ 
/* HTTP://www.emreyildirim.com                          */
/* Yorumlar/�neriler: phpnuke@emreyildirim.com          */
/********************************************************/

global $ya_config;

/*****************************************************/
/* From file : New for 3.2.0                         */
/*****************************************************/
define("_YA_REGOPTIONS","�yelik Se�enekleri");
define("_YA_MAILOPTIONS","Email Se�enekleri");
define("_YA_GRAPOPTIONS","Grafik Se�enekleri");
define("_YA_EXPOPTIONS","�yelik Dondurma Se�enekleri");
define("_YA_LMTOPTIONS","Limit Ayarlama Se�enekleri");
define("_YA_SERVERMAILNOTE","(Yaln�zca server email g�nderebiliyorsa ge�erlidir.)");

define("_MEMAPL","�ye Kayd� Onayland�");
define("_SUBUSERS","Maillist �yeleri");
define("_UNSUBUSER","Listeden ��kar");
define("_YOUBAD","HATA: Yapmak istedi�iniz i�lemler hatal�d�r.");
define("_RESENTMAIL","�ye i�in Onay kodu G�nderilmi�tir");
define("_APPLICATIONSUB","�ye Kay�t Talebiniz Hakk�nda");
define("_TOAPPLY","Sitemize Kay�t Ba�vurusu Yap�lm��t�r");
define("_THANKSAPPL","Kay�t Oldu�unuz ��in Te�ekk�rler");
define("_ACCOUNTRESERVED","�ye Kayd� �ste�iniz Kabul Edildi");
define("_WAITAPPROVAL","Kayd�n�z Y�neticiler taraf�ndan g�zden ge�irilip onayland���nda yada red edildi�inde bir mail al�caks�n�z");
define("_USERAPPFINALSTEP","Yapman�z Gerekenler");
define("_USERAPPLOGIN","Yeni �ye Kayd�");
define("_YOUAREPENDING","Ho�Geldiniz! �ye Kayd� iste�iniz taraf�m�za ula�t� g�zden ge�irilip onayland���nda bir mail al�caks�n�z.");
define("_YA_GD","GD Library Deste�i Bulunamad�");
define("_YA_ADDTO","Ba�ar� ile eklendi");
define("_YA_FROM","G�nderen");
define("_YA_APLTO","Yeni �ye Kayd� yap�ld�");
define("_MEMACT","Yeni �ye Kayd�");
define("_ACTDISABLED","�ye Kayd�m�z Ge�ici Bir S�re Dondurulmu�tur");
define("_YA_GO","Git");
define("_YA_PAGES","Sayfa Bulunuyor");
define("_YA_OF","Toplam");
define("_YA_SELECTPAGE","Sayfa Se�imi");
define("_TPOINTS","T�m Puanlar");
define("_SITEGROUPS","Site Gruplar�");
define("_NPOINTS","Puan�n�z");
define("_SGMEMBERS","�yeler");
define("_USERGUEST","Misafir Defterim");
define("_USERBOOK","Fotoalbum");
define("_SUBUSERASK","Maillist �yeli�i");
define("_YEARS","Y�l");
define("_SUBPERIOD","�yelik S�resi");
define("_SHOWMAIL","Mailimi G�ster");
define("_FINDTBY","Kullan�c� Bul isme G�re");
define("_FINDUBY","Kullan�c� Bul �ye ismine g�re");
define("_YA_CHKAUTOSUS","Otomatik �yelik Dondurma");
define("_USERID","Kullan�c� ID");
define("_OK","Tamam");
define("_YA_ADMINISTRATION","Y�netim Men�s�");
define("_USERSCONFIG","Kullan�c� Ayarlar�");
define("_ADDUSER","Kullan�c� Ekle");
define("_ACTIVEUSERS","Aktif Kullan�c�lar");
define("_SUSPENDUSERS","Dondurulan Kullan�c�lar");
define("_DELETEUSERS","Silinen Kullan�c�lar");
define("_WAITINGUSERS","Bekleyen Kullan�c�lar");
define("_USERADMIN","�ye y�netimi");
define("_NAME","�sminiz");
define("_FAKEEMAIL","Sahte Email");
define("_URL","Web Sitesi");
define("_ALLOWUSERS","Bu se�ene�i i�aretlerseniz Mailiniz herkes taraf�ndan g�r�lecektir");
define("_NEWSLETTER","Gazete");
define("_ADDUSERBUT","Kullan�c� Ekle");
define("_CANCEL","Vazge�");
define("_REGDATE","Kay�t Zaman�");
define("_FUNCTIONS","��lemler");
define("_DETUSER","Detaylar");
define("_MODIFY","D�zenle");
define("_PROMOTE","R�tbelendir");
define("_PERMISSIONS","Eri�im Haklar�");
define("_SURE2PROMOTE","Bu �yeyi yetkilendir");
define("_REQUIREDNOCHANGE","Daha sonra de�i�tirilemez");
define("_PROMOTEUSER","R�tbe Y�kselt");
define("_ARTICLES","Haber");
define("_ENCYCLOPEDIA","Ansiklopedi");
define("_BBFORUM","Forum");
define("_SECTIONS","��erik");
define("_WEBLINKS","Linkler");
define("_CONTENT","B�l�mler");
define("_SURVEYS","Anket");
define("_DOWNLOAD","Dosyalar");
define("_FAQ","S.S.S");
define("_REVIEWS","�zlenimler");
define("_TOPICS","Konular");
define("_SUSPEND","Dondur");
define("_YA_WEEKS","Hafta");
define("_AUTOSUSPEND","Dondur");
define("_YA_PERPAGE","Sayfa Ba��na");
define("_YA_USERS","�yeler");
define("_YA_PERPAGENOTE","G�r�nt�le");
define("_AUTOSUSNOTE","Kullan�lm�yan Hesab� Dondur");
define("_REQUIREADMIN","Admin Onay�");
define("_ACTALLOWREG","Onay Gerektirmez");
define("_USEGFXCHECK","G�venlik Kodu");
define("_USEACTIVATE","Onay Kodu");
define("_SERVERMAIL","Mail G�nderimi");
define("_ACTNOTIFYADD","�ye Kay�tlar�n� Bildir");
define("_ACTALLOWDELETE","Herkes Kayd�n� Silebilir");
define("_ACTNOTIFYDELETE","Silinen �yeyi Bildir");
define("_ACTALLOWTHEME","Tema De�i�ikli�ine izin ver");
define("_ACTALLOWMAIL","Mail De�i�ikli�ine izin ver");
define("_YA_NC","Gerek yok");
define("_YA_RC","Sadece �ye olurken");
define("_YA_LC","Sadece Giri�lerde");
define("_YA_CA","T�m Sistemde");
define("_DIRECT1","<p>Herhangi bir sorun ile kar��la��rsan�z site admini ile kontak kurmak i�in <a href='mailto:");
define("_DIRECT2","'><b>T�klay�n</b></a><br><br>\n");
define("_BESUREACT","Giri�i onaylay�n");
define("_ACCTCHANGE","Bilgilerimi</br>De�i�tir");
define("_ACCTHOME","Ana Sayfa</br>De�i�tir");
define("_ACCTCOMMENTS","Yorum</br>Ayarlar�");
define("_ACCTJOURNAL","G�nl���n�z");
define("_ACCTTHEME","Tema</br>De�i�ikli�i");
define("_ACCTEXIT","��k��</br>Log Out");
define("_NOHTML","Html Kullanamass�n�z");
define("_ACCSUSPENDED","Hesab�n�z Bir S�redir Kullan�lmad���ndan Dondurulmu�tur");
define("_RESTORE","Etkinle�tir");
define("_SURE2RESTORE","Bu Kullan�c�y� etkinle�tir");
define("_RESTOREUSER","Etkinle�tir");
define("_FORCHANGES","�ifreyi de�i�tirmek istemiyorsan�z bo� b�rak�n");
define("_ACCTRESTORE","Kullan�c� Hesab� Ba�ar�yla Aktif Hale Getirildi");
define("_SORRYTO","De�erli �yemiz");
define("_HASRESTORE","Sitesindeki hesab�n�z bir s�re kullanmad���n�z i�in dondurulmu�tur. iste�iniz �zerine hesab�n�z y�netim taraf�ndan uygun g�r�lerek tekrar kullan�l�r hale getirilmi�tir");
define("_RETYPEPASSWORD","�ifre Tekrar�");
define("_YOUWILLRECEIVE2","Bitire t�klad���n�zda Hesab�n�z etkinele�tirilecek ve sisteme hemen giri� yapabileceksiniz.");
define("_FINISHUSERCONF2","Hesab�n�z kullan�labilir durumdad�r �imdi Giri� Yapmak i�in");
define("_FINISHUSERCONF3"," <b>T�klay�n</b>");
define("_REGISTRATIONSUB","�yelik Bilgileriniz");
define("_LAST10SUBMISSION","Son 10 Haberiniz");
define("_YA_LASTVISIT","Son Ziyaretiniz");
define("_YA_POINTS","Puan�n�z");
define("_SUSPENDUSER","Dondur");
define("_DELETEUSER","Sil");
define("_REALNAME","Ger�ek �sminiz");
define("_YA_AVCP","Avatar Kontrol Paneli");
define("_YA_CURRAV","�u Andaki Avatar�n�z");
define("_YA_AVINF1","Avatar Boyutlar�");
define("_YA_AVINF2","X");
define("_YA_AVINF3","Olmal� ve Maksimum A��rl�k.");
define("_YA_SELAVGALL","Galeriyi Se�in");
define("_YA_SHOWGALL","Galeriyi G�r�nt�le");
define("_YA_UPLOADURL","Avatar Y�kleme Adresi");
define("_YA_UPLOADAV","Avatar Y�kleyin");
define("_YA_DISABLED","Kapal�");
define("_YA_OFFSITE","Avatar y�kleme sitemize y�kleme");
define("_YA_ONCAT","G�r�nt�lenen Dizin");
define("_YA_TOSELCTAVAT","Bir avatar se�mek i�in avatara t�klay�n.");
define("_YA_AVATARSUCCESS","Avatar se�imi ba�ar�l�");
define("_YA_AVATARFOR","Bu Avatar ");
define("_YA_SAVED","i�in kaydedildi.");
define("_YA_NEWAVATAR","Yeni Avatar�n�z.");
define("_YA_BACKPROFILE","Profil D�zenle");
define("_YA_DONE","Bitti");
define("_YA_PASSLENGTH","�ifreniz En az ".$ya_config['pass_min']." En fazla ".$ya_config['pass_max']." karakter olmal�d�r.");
define("_YA_NICKLENGTH","Nick/Rumuz en az ".$ya_config['nick_min']." En fazla ".$ya_config['nick_max']." Karakter olmal�d�r.");
define("_RETYPEEMAIL","Mail adresinizi Onaylay�n");
define("_ERRORREG","Kay�t Hatas�");
define("_YA_PASSWORD","�ifre");
define("_FORACTIVATION","Etkinle�tirme Ba�ar�l�");
define("_ACTERROR","Etkinle�tirme Hatas�</br>Bu Hesap Zaten Etkin");
define("_ACTMSG2","Ayarlar�n�z Kaydedildi</br><b>Y�nlendiriliyorsunuz L�tfen Bekleyin</b>");
define("_YA_NA","Belirtilmemi�");
define("_NORMALUSERS","Kay�tl� �yeler");
define("_YA_SEARCH","Ara");
define("_YA_FIND","�yelerde Bul");
define("_YA_REGLUSER","Kay�tl� kullan�c�lar");
define("_YATEMPUSER","Bekliyen �yeler");
define("_YA_BY","�sme G�re");
define("_YA_MATCH","Kar��la�t�rmalar");
define("_YA_EQUAL","E�le�melerde");
define("_YA_LIKE","Benzerleri");
define("_YA_DEACTIVATE","�yeyi Sil");
define("_SURE2DELETE","Silinecek �ye");
define("_DELETEREASON","�yelik silinme sebebi");
define("_ACCTDELETE","Kullan�c� Hesab� Ba�ar�yla Silindi");
define("_RETURN2","Tamam");
define("_REMOVE","Sil");
define("_SURE2REMOVE","Bu �yeyi silmek istedi�inize eminmisiniz");
define("_REMOVEUSER","Evet");
define("_ACCTREMOVE","Bu Hesap Silindi.");
define("_HASDELETE","Sitemizde Bulunan hesab�n�z site y�netimi taraf�ndan uygunsuz davran��larda bulundu�unuzdan yada iste�iniz �zere silinmi�tir.");
define("_YA_REGOPTIONS","�ye kay�t ayarlar�");
define("_YA_MAILOPTIONS","Sistem Maili g�nderim ayarlar�");
define("_YA_SERVERMAILNOTE","G�nderilen mailleri bildir");
define("_EMAILVALIDATE","Email Onayl�");
define("_YA_GRAPOPTIONS","Grafik ayarlar�");
define("_YA_EXPOPTIONS","Zaman A��m�");
define("_YA_NONEXPIRE","Zaman A��m� yok");
define("_YA_WEEK","Hafta");
define("_YA_EXPIRING","�nceden Bildir");
define("_YA_DAY","G�n �nceden Bildir");
define("_YA_DAYS","G�n �nceden Bildir");
define("_YA_EXPIRINGNOTE","�ye Hesab� Dondurulmadan belirlenmi� g�n i�inde bilgi mesaj� g�nderir.");
define("_YA_LMTOPTIONS","Limit ayarlar�");
define("_YA_BADNICK","Yasak Nick/Rumuzlar");
define("_YA_1PERLINE","Buraya eklenen Nick/Mail adresleri kullan�m� yasaklanm�� olacakt�r");
define("_YA_BADMAIL","Yasak Mail Uzant�lar�");
define("_YA_NICKMIN","En K���k Nick/Rumuz");
define("_YA_CHARS","Karakter");
define("_YA_NICKMAX","En Uzun Nick/Rumuz");
define("_YA_PASSMIN","En K�sa �ifre");
define("_YA_PASSMAX","En Uzun �ifre");
define("_USERNAME","Kullan�c� Ad�");
define("_RESEND","Onay Kodunu Yeniden G�nder");
define("_APPROVE","Kullan�c�y� Onayla");
define("_DENY","Kullan�c� �yelik i�lemini iptal et");
define("_SURE2ACTIVATE","�yelik iptali");
define("_APPROVEUSER","�yeli�ini Ba�lat");
define("_SURE2RESEND","Bu �ye �yeli�ini tamamlamam�� �yeli�inin ba�lamas� i�in onay kodu g�ndermek istermisin");
define("_RESENDMAIL","Bu �ye i�in onay kodu g�nder");
define("_RETURN","Devam et");
define("_CHECKNUM","�yelik kodu");
define("_YA_CHNGRISK","�ye ad�n� de�i�irseniz �ye sisteme tekrar giri� yapamayabilir...");
define("_SURE2DENY","Bu kullan�c�n�z�n �yeli�ini iptal etmek istiyormusunuz");
define("_DENYREASON","Neden iptal edildi!!!");
define("_DENYUSER","Bu �yeli�i iptal et");
define("_ACCTDENY","Bu �yeli�i ger�ekten iptal etmek istiyormusunuz?");
define("_USERNOEXIST","�ye bulunamad�");
define("_ACCTDENY","�yeli�iniz iptal edildi!!!");
define("_HASDENY","Sitesindeki �yelik ba�vurunuz site y�netimince iptal edilmi�tir.");
define("_SURE2SUSPEND","Bu �yenizin hesab�n� dondurmak istiyormusunuz");
define("_SUSPENDREASON","Hesab�n dondurulma sebebi");
define("_ACCTSUSPEND","Kullan�c� Hesab� Ba�ar�yla Donduruldu");
define("_YA_QUERY","�yelerde ara");
define("_YA_TEMPUSER","Bekleyen �yelerde ara");
define("_ACCTMODIFY","�ye Hesab� D�zenlendi");
define("_USERPROMOTED","�ye R�tbelendirmesi yapt�n�z");
define("_NAMEERROR","isim girmediniz");
define("_ACCTSUSPEND","Hesab�n�z durduruldu");
define("_HASSUSPEND","Sitesindeki Hesab�n�z y�netimce durdurulmu�tur");
define("_USERUPDATE","�yelik Bilgilerinizi D�zenleyin");
define("_YA_UPLOADFORUM","Kendi avatar�n�z� y�kleyin");
define("_YA_AVCOPIED","Verdi�iniz linkdeki avatar kar�� siteden kopyalanacakt�r");
define("_YA_SUBMITBUTTON","Avatar�n�z� kaydedin");
define("_YA_AVATARGALL","Avatar Galeri");
define("_NOPOSTSUBJECT","Konu Belirtmemi�siniz");
define("_LAST10DOWNLOAD","Ekledi�iniz Son 10 Dosya");
define("_LAST10BBPOST","Forumdaki Son 10 Mesaj�n�z");
define("_LAST10BBTOPIC","Forumdaki Son 10 Ba�l���n�z");
define("_MEMDEL","�yeli�iniz silindi");
define("_YA_NOREPLY","Bu Mesaj Size Bilgi Ama�l� G�nderildi L�tfen Bu Mesaj� Cevaplamay�n");
define("_ACCTAPPROVE","$sitename �yelik i�lemleri tamamland�");
define("_BNICK","�ye Ad�");
define("_BPASS","�ifre");
define("_BCODE","G. Kodu");
define("_BTYPECODE","Kodu giriniz");
define("_BLOGIN","Giri�");
define("_HASAPPROVE","Sitemize yapt���n�z <b>�yelik Ba�vurunuz</b> Onayland�");
define("_USERGUEST","Misafir Defterim");
define("_USERBOOK","Alb�m�m");
define("_YA_ACCNOFIND","�ye Hakk�nda Bilgi Bulunamad�");
define("_NAMERESTRICTED","Bu Nick/Rumuz kullanamazs�n�z Y�netim Taraf�ndan kullan�m� yasaklanm��.");
define("_EMAILDIFFERENT","Bu email adresi ile kay�t yapamazs�n�z L�tfen do�ru bir email adresi giriniz.");
define("_OR","?");
define("_SUREDELETE","�yeli�inizi Silmek istedi�inizden Eminmisiniz");
define("_DELETEACCT","�yelik Sil");
define("_YA_MUSTSUPPLY","<i>Kullan�c� Ad�n�z</i> ve <i>email adresiniz address</i>.");
define("_EMAIL","Email");
define("_YES","Evet");
define("_NO","Hay�r");
define("_OPTIONAL","(opsiyonel)");
define("_REQUIRED","(gerekli)");
define("_SAVECHANGES","De�i�iklikleri Kaydet");
define("_THRESHOLD","Ba�lang��");
define("_NOCOMMENTS","Yorum Yok");
define("_NESTED","��-i�e");
define("_FLAT","D�z");
define("_THREAD","S�ral�");
define("_OLDEST","Eski Ba�a");
define("_NEWEST","Yeni Ba�a");
define("_HIGHEST","Y�ksek Skorlar Ba�a");
define("_ERRORINVEMAIL","HATA: Ge�ersiz Email");
define("_ERROREMAILSPACES","HATA: Email adresi bo�luk i�eremez");
define("_ERRORINVNICK","HATA: Ge�ersiz Kullan�c� Ad�");
define("_NICK2LONG","Nickname �ok uzun. 25 karakterden k�sa olmal�");
define("_NAMERESERVED","HATA: Bu isim kullan�mda");
define("_NICKNOSPACES","HATA: Nickname bo�luk i�eremez");
define("_NICKTAKEN","HATA: Bu Kullan�c� Ad� daha �nce al�nm��");
define("_EMAILREGISTERED","HATA: Email adresi zaten kay�tl�");
define("_UUSERNAME","Kullan�c� Ad�");
define("_FINISH","Bitir");
define("_YOUUSEDEMAIL","Siz veya baska biri email hesabinizi kullanarak");
define("_TOREGISTER","bu siteye kayit yaptirdi:");
define("_FOLLOWINGMEM","Uyelik bilgileriniz asagidadir:");
define("_UNICKNAME","-Nickname:");
define("_UPASSWORD","-Sifre:");
define("_USERPASS4","Kullanici Sifresi:");
define("_YOUAREREGISTERED","Kayd�n�z tamamland�. �ifreniz belirtti�iniz email adresinize g�nderildi.");
define("_THISISYOURPAGE","Bu sizin ki�isel sayfan�z.");
define("_AVATAR","Logo");
define("_WEBSITE","Web Sitesi");
define("_ICQ","ICQ Numaras�");
define("_AIM","AIM Numaras�");
define("_YIM","YIM Numaras�");
define("_MSNM","MSNM Numaras�");
define("_LOCATION","�ehir");
define("_OCCUPATION","Meslek");
define("_INTERESTS","�lgi Alanlar�");
define("_SIGNATURE","�mza");
define("_MYHOMEPAGE","Web Sitem:");
define("_MYEMAIL","Email'im:");
define("_EXTRAINFO","Ekstra Bilgi");
define("_NOINFOFOR","Bilgi bulunamad�:");
define("_LAST10COMMENTS","Son 10 Yorumunuz");
define("_LAST10SUBMISSIONS","Son 10 Haberiniz");
define("_LOGININCOR","Ge�ersiz Giri�! L�tfen Tekrar Deneyin...");
define("_USERLOGIN","Kullan�c� Giri�i");
define("_USERREGLOGIN","Kullan�c� Kay�t/Giri�i");
define("_REGNEWUSER","Yeni Kullan�c� Kayd�");
define("_LIST","Liste");
define("_NEWUSER","Yeni Kullan�c�");
define("_PASSWILLSEND","(�ifreniz email adresinize g�nderilecek)");
define("_COOKIEWARNING","Not: Hesap se�enekleri cookie tabanl�d�r.");
define("_ASREGUSER","Kay�tl� bir kullan�c� olarak:");
define("_ASREG1","�sminizle yorum yazabilir");
define("_ASREG2","�sminizle haber g�nderebilir");
define("_ASREG3","Anasayfada ki�isel bir kutu yaratabilir");
define("_ASREG4","Anasayfadaki haber say�s�n� se�ebilir");
define("_ASREG5","Yorumlar� ki�iselle�tirebilir");
define("_ASREG6","Farkl� temalar se�ebilir");
define("_ASREG7","ve daha pek �ok �zellikten yararlanabilirsiniz...");
define("_REGISTERNOW","�imdi kay�t olun! �cretsiz!");
define("_WEDONTGIVE","Ki�isel bilgileriniz gizli tutulacakt�r.");
define("_ALLOWEMAILVIEW","Di�er kullan�c�lar email'imi g�rebilir");
define("_OPTION","Mailimi G�ster");
define("_PASSWORDLOST","�ifrenizi mi kaybettiniz?");
define("_NOPROBLEM","Sorun de�il. Nickname'inizi yazarak g�nder butonuna t�klay�n. Onay kodunuzu ald�ktan sonra, nickname'inizi ve onay kodunuzu tekrar yaz�n. �ifrenizi size g�nderece�iz.");
define("_CONFIRMATIONCODE","Onay Kodu");
define("_SENDPASSWORD","�ifre G�nder");
define("_YOUARELOGGEDOUT","Sistemden ��kt�n�z!");
define("_SORRYNOUSERINFO","�zg�n�m, kullan�c� bilgisi bulunamad�");
define("_USERACCOUNT","Bu email");
define("_AT","adli");
define("_HASTHISEMAIL","kullanicisi ile ilgilidir.");
define("_AWEBUSERFROM","");
define("_HASREQUESTED","IP adresli biri sifrenizi istedi.");
define("_YOURNEWPASSWORD","Yeni sifreniz:");
define("_YOUCANCHANGE","Giris yaptiktan sonra degistirebilirsiniz:");
define("_IFYOUDIDNOTASK","Bu mesaji istemediyseniz endiselenmeyin. Bu mesaji sadece siz goruyorusunuz. Hatali bir gonderim de olsa yeni sifreniz ile giris yapmalisiniz.");
define("_UPDATEFAILED","Bilgiler g�ncellenemiyor. Y�neticiyle ileti�im kurun.");
define("_PASSWORD4","Kullan�c�");
define("_MAILED"," i�in �ifre g�nderildi.");
define("_CODEREQUESTED","sifre degisimi icin onay kodu istedi.");
define("_YOURCODEIS","Onay Kodunuz:");
define("_WITHTHISCODE","Bu kod ile yeni bir sifre alabiliceginiz yer:");
define("_IFYOUDIDNOTASK2","Boyle bir istekte bulunmadiysaniz bu email'i silebilirsiniz.");
define("_CODEFOR","Onay Kodu:");
define("_USERPASSWORD4","Kullanici Sifresi:");
define("_UREALNAME","Ger�ek �sim");
define("_UREALEMAIL","Ger�ek Email");
define("_EMAILNOTPUBLIC","(Bu email sadece �ifrenizi unuttu�unuzda kullan�lacak)");
define("_UFAKEMAIL","Sahte Email");
define("_EMAILPUBLIC","(Bu email topluma a��k olacak)");
define("_YOURHOMEPAGE","Ana Sayfan�z");
define("_YOURAVATAR","Avatar�n�z");
define("_YICQ","ICQ'nuz");
define("_YAIM","AIM'iniz");
define("_YYIM","YIM'iniz");
define("_YMSNM","MSNM'iniz");
define("_YLOCATION","�ehriniz");
define("_YOCCUPATION","Mesle�iniz");
define("_YINTERESTS","�lgi Alanlar�n�z");
define("_255CHARMAX","(En fazla 255 karakter. HTML kullanabilirsiniz)");
define("_CANKNOWABOUT","(En fazla 255 karakter. Hakk�n�zda bilinmesi gerekenleri yaz�n)");
define("_TYPENEWPASSWORD","(de�i�tirmek i�in yeni �ifreyi iki kez girin)");
define("_SOMETHINGWRONG","Hata olu�tu...");
define("_PASSDIFFERENT","�ifreler birbirinden farkl�. �kisi de ayn� olmal�.");
define("_CHARLONG","karakter uzunlu�unda olmal�");
define("_AVAILABLEAVATARS","Kullan�labilir Logo Listesi");
define("_NEWSINHOME","Anasayfadaki Haber Say�s�");
define("_MAX127","(en fazla 127):");
define("_ACTIVATEPERSONAL","Ki�isel Men�y� Etkinle�tir");
define("_CHECKTHISOPTION","(Bu se�ene�i a�t���n�zda a�a��daki metin anasayfada g�r�nt�lenecek)");
define("_YOUCANUSEHTML","(�rne�in link vermek i�in HTML kullanabilirsiniz)");
define("_SELECTTHEME","Bir Tema Se�in");
define("_THEMETEXT1","Bu se�enek t�m sitenin g�r�n�m�n� de�i�tirecek.");
define("_THEMETEXT2","De�i�iklikler sadece sizin i�in ge�erli olacak.");
define("_THEMETEXT3","Her kullan�c� siteyi farkl� bir tema ile izleyebilir.");
define("_DISPLAYMODE","G�r�n�m Modu");
define("_SORTORDER","S�ralama");
define("_COMMENTSWILLIGNORED","Bu ayar�n alt�nda puan alan yorumlar g�r�nmeyecek.");
define("_UNCUT","Oldu�u Gibi");
define("_EVERYTHING","Neredeyse T�m�");
define("_FILTERMOSTANON","Anonimleri Filtrele");
define("_USCORE","Puan");
define("_SCORENOTE","Anonim 0'dan, kay�tl� kullan�c� 1'den ba�lar. Y�neticiler puan ekler veya ��kar�r.");
define("_NOSCORES","Puanlar� G�sterme");
define("_HIDDESCORES","(Puan Sakla: Hala ge�erli olacaklar, fakat siz g�rmeyeceksiniz.)");
define("_MAXCOMMENT","En Fazla Yorum Uzunlu�u");
define("_TRUNCATES","(Uzun yorumlar� keser ve devam� ba�lant�s� koyar. Kapatmak i�in b�y�k bir say� girin)");
define("_BYTESNOTE","byte (1024 byte = 1K)");
define("_USENDPRIVATEMSG","�zel Mesaj g�nder:");
define("_THEMESELECTION","Tema Se�imi");
define("_COMMENTSCONFIG","Yorum Ayarlar�");
define("_HOMECONFIG","Anasayfa Ayarlar�");
define("_PERSONALINFO","Ki�isel Bilgiler");
define("_USERSTATUS","Kullan�c� Durumu");
define("_ONLINE","Ba�l�");
define("_OFFLINE","Ba�l� De�il");
define("_CHANGEYOURINFO","Bilgilerinizi De�i�tirip D�zenleyin");
define("_CONFIGCOMMENTS","Yorum Ayarlar�");
define("_CHANGEHOME","Kendi Men�n�z� Ekleyebilirsiniz");
define("_LOGOUTEXIT","Sistemden ��k��");
define("_SELECTTHETHEME","Site Teman�z� Se�in");
define("_PRIVATEMESSAGES","�zel Mesajlar�n�z");
define("_EDITUSER","Kullan�c� D�zenle");
define("_RECEIVENEWSLETTER","Gazetemize abone olmak ister misiniz?");
define("_NOTSUBSCRIBED","Gazetemize abone de�ilsiniz");
define("_SUBSCRIBED","Gazetemize abone oldunuz");
define("_USERCHECKDATA","l�tfen a�a��daki bilgileri kontrol edin. Hepsi do�ruysa \"Bitir\" butonu ile kay�t i�leminizi tamamlayabilirsiniz. Unutmay�n mail adresinizi ge�ersiz yazman�z durumunda �yeli�iniz asla aktif olmayacakt�r. Bilgileriniz ge�ersizse l�tfen geri d�n�p gerekli d�zenlemeyi yap�n.");
define("_USERFINALSTEP","Yeni Kullan�c� Kayd�: Son Ad�m");
define("_ACCOUNTCREATED","Yeni Kullan�c� Hesab� Yarat�ld�!");
define("_THANKSUSER","Kaydoldu�unuz i�in te�ekk�rler:");
define("_YOUCANLOGIN","Birka� saniye i�inde sistemimizden �ifrenizi i�eren bir email alacaks�n�z. Daha sonra <a href=\"modules.php?name=Your_Account\">buradan</a> giri� yapabilirsiniz. �ifrenizi de�i�tirmeyi ve hesap se�eneklerinizi ayarlamay� unutmay�n. Servislerimizden memun kalaca��n�z� umuyoruz.");
define("_BROWSEUSERS","Kullan�c�lara G�zat");
define("_SEARCHUSERS","Kullan�c�lar� Ara");
define("_BROADCAST","Genel Mesaj Yay�nla");
define("_BROADCASTTEXT","Buradan bir <i>genel mesaj</i> yay�nlayabilirsiniz (en fazla 255 karakter). Bu mesaj 10 dakika boyunca sitedeki t�m �yelere g�sterilecektir. Ba�l� olan her kullan�c� mesaj�n�z� sadece bir kez site logosunun alt�nda k�rm�z� bir �ubukta g�recektir. Her kullan�c� bu �zelli�i <a href=\"modules.php?name=Your_Account&op=edithome\">buradan</a> iptal edebilir. L�tfen bu �zelli�i k�t�ye kullanmay�n. HTML kodu kullanamazs�n�z.");
define("_SEND","G�nder");
define("_MESSAGEACTIVATE","Genel Mesaj Yay�n�n� Etkinle�tir?");
define("_BROADCASTSENT","Genel mesaj yay�n�n�z g�nderildi.");
define("_BROADCASTNOTSENT","<b>HATA:</b> Mesaj yay�n�n�z bo� veya yak�n zaman i�inde bir mesaj g�ndermi�siniz. Ba�ka bir mesaj yay�nlamak i�in 10 dakika beklemelisiniz.");
define("_RETURNPAGE","Ki�isel sayfan�za geri d�n�n");
define("_MYHEADLINES","Ba�l�klar�m");
define("_SELECTASITE","Ba�l�klar�n� okumak istedi�iniz siteyi se�in:");
define("_SELECTASITE2","Bir Web Sitesi Se�in");
define("_ORTYPEURL","Veya tercih etti�iniz sitenin RSS/XML ba�l�k adresini yaz�n");
define("_GO","Git");
define("_HEADLINESFROM","Ba�l�klar:");
define("_WEBMAIL", "WebMail");
define("_MESSAGES","Mesajlar�n�z� Okuyun");
define("_RETURNACCOUNT", "Hesab�n�z Sayfas�na Geri D�n");
define("_ACCESSTO", "Eri�im:");
define("_CREATEJOURNAL", "G�nl���n� Yarat");
define("_READHEADLINES", "�zel ba�l�klar� oku");
define("_CREATEJOURNAL", "Kendi G�nl���n� Yarat");
define("_READHEADLINES", "Ba�l�klar� Oku");
define("_POPMSGACTIVE","�zel Mesajlarda PopUp Etkinle�tirilsin mi?");
define("_READMYJOURNAL","G�nl���m� Oku");
define("_AVATARNOTE","Kay�tl� kullan�c� olarak kendi avatar�n�z� se�ebilirsiniz.");
define("_USRNICKNAME","Takma Ad/Kullan�c� Ad�");
define("_ALWAYSSHOWEMAIL","E-mail adresimi her zaman g�ster.");
define("_HIDEONLINE","Online oldu�umu gizle");
define("_REPLYNOTIFY","Cevaplardan beni herzaman haberdar et");
define("_REPLYNOTIFYMSG","Yazd���n�m bir konuya yeni mesaj geldi�inde E-mail ile haber ver. Bu �zellik her yeni mesajda de�i�tirilebilir.");
define("_PMNOTIFY","Yeni �zel mesaj geldi�inde E-mail ile haber ver.");
define("_POPPM","Her yeni �zel mesajda PopUp penceresi a�");
define("_POPPMMSG","Yeni bir �zel mesaj ald���n�zda bilgilendirmek i�in bir PopUp penceresi a��lacak.");
define("_ATTACHSIG","Her zaman imzam� ekle");
define("_ALLOWBBCODE","Herzaman BBCode Serbest");
define("_ALLOWHTMLCODE","Herzaman HTML Serbest");
define("_ALLOWSMILIES","Herzaman Smilieler Aktif");
define("_FORUMSTIME","Forumlar Saat B�lgesi");
define("_FORUMSDATE","Forumlar Saat Format�");
define("_FORUMSDATEMSG","Kullan�lan s�z dizimi standart PHP <a href=\"http://www.php.net/date\">date()</a> fonksiyonuyla ayn�d�r.");
define("_YA_SECURITYCODE","G�venlik Kodu");
define("_YA_TYPESECCODE","G�venlik Kodunu Girin");
define("_NEWUSERERROR","Yeni Kullan�c� Olu�turma Hatas�!");
define("_SECCODEINCOR","G�venlik kodu ge�ersiz, L�tfen geri d�n�p kodu do�ru girin.");
define("_RETYPEPASSWD","�ifre Onay�");
define("_ALLREQUIRED","B�t�n kutular�n doldurulmas� zorunludur.");
define("_YOUWILLRECEIVE","Sistem taraf�ndan mail adresinize bir onay maili g�nderilecek. Gelen maildeki ba�lant�y� 24 saat i�inde ziyaret edip �yeli�inizi aktif hale getirmelisiniz.");
define("_BLANKFORAUTO","Bo� b�rak�rsan�z �ifreniz otomatik olarak olu�turulacak.");
define("_TOFINISHUSER","Kay�t i�lemini tamamlad�ktan sonra gelen maildeki adresi ziyaret ederek �yeli�inizi 24 saat i�inde aktif hale getirmezseniz, �yelik kayd�n�z sistem taraf�ndan silinecek ve yeniden kay�t olman�z gerekecektir.");
define("_YOUPASSMUSTBE","Sizin �ifreniz Olmal�d�r");
define("_FINISHUSERCONF","Yeni kullan�c� kayd� i�in ba�vurunuz i�leme konuldu. K�sa s�re sonra sistem taraf�ndan g�nderilen bir onay maili alacaks�n�z, gelen maildeki ba�lant�y� 24 saat i�inde ziyaret ederek �yeli�inizi aktif hale getirmelisiniz.");
define("_ACTIVATIONERROR","Yeni Kullan�c� Etkinle�tirme Hatas�!");
define("_ACTIVATIONYES","Yeni Kullan�c� Etkinle�tirme");
define("_ACTMSG","Hesab�n�z ba�ar� ile etkinle�tirilmi�tir. L�tfen <a href=\"modules.php?name=Your_Account\">buraya t�klayarak</a> �ifreniz ve kullan�c� ad�n�z ile sisteme giri� yap�n.");
define("_ACTERROR1","Ge�ersiz yeni kullan�c� etkinle�tirme kodu!<br><br>L�tfen g�nderilen E-maildeki adresi manuel olarak explorere yaz�p deneyin. Yada <a href=\"modules.php?name=Your_Account\">buraya</a> t�klayarak hesab�n�za giri� yapmay� veya yeniden kay�t olmay� deneyin.");
define("_ACTERROR2","Veri taban�nda bu bilgiye sahip bir kullan�c� bulunmamakta.<br><br> <a href=\"modules.php?name=Your_Account\">Buraya</a> t�klayarak yeni bir kullan�c� olarak kay�t olabilirsiniz.");
define("_ACTIVATIONSUB","Yeni Kullan�c� Hesab� Etkinle�tirme");

// NEW FROM CNB YOUR ACCOUNT
define("_255CHARMAX","(en fazla 255 karakter)");
define("_YA_COOKIECONFIG","Kullan�c� Cookie Se�enekleri");
define("_COOKIETIMELIFE","Cookie Zaman�");
define("_COOKIETIMELIFENOTE","Toplam cookie zaman� kullan�c�n�n sistem saati ile cookie zaman�n�n toplam�na e�ittir");
define("_COOKIEPATHNOTE1","Sadece<i>&nbsp;Kullanici ��letim Sistemini Kapatana Kadar</i><br> se�ili de�ilse ge�erlidir");
define("_COOKIEPATHNOTE2","Otomatik dizin i�in bo� b�rak�n�z<br><b>Belirli bir dizini belirtmek risklidir!</b>");
define("_YA_AUTOSUSPENDMAINNOTE","Sitenin y�klenme h�z�n� d���rebilir.<br> Sadece tek sayfa g�steriminde kullanabilirsiniz.");
define("_YA_SECOND","Saniye");
define("_YA_SECONDS","Saniye");
define("_YA_MINUTE","Dakika");
define("_YA_MINUTES","Dakika");
define("_YA_HOUR","Saat");
define("_YA_HOURS","Saat");
define("_YA_MONTH","Ay");
define("_YA_MONTHS","Ay");
define("_YA_COOKIELOGOUTPAG","Kullan�c� ��letim Sistemini Kapatana Kadar");
define("_YA_COOKIEAUTOLOGOUT","Giri�leri Blokla");
define("_COOKIEPATH","Cookie Dizini");
define("_COOKIEINACTIVITY","Sayfa g�r�nt�leme i�in izin verilen zamana��m�<br>(<i>Se�ti�iniz zaman periodunda kullan�c� herhangi bir i�lem yapmaz ise <br>otomatik olarak siteden ��k�� yapm�� olur!</i>");
define("_YA_COOKIEINACTNOTUSER","Zaman A��m� Yok");
define("_YA_COOKIEDELCOOKIE","�lk sayfa g�r�nt�lendi�i anda ��k�� yap");
define("_AUTOSUSPENDMAIN","B�t�n sayfa g�sterimlerinde <br>kullan�c�y� otomatik olarak dondur");
define("_YA_ADDFIELD","Alan Olu�tur");
define("_FIELDNAME","Alan Ad�");
define("_FIELDVALUE","�ntan�ml� De�er");
define("_FIELDSIZE","Uzunluk");
define("_FIELDNEED","Durum");
define("_FIELDVPOS","S�ra");
define("_ADDFIELD","Alanlar� Kaydet");
define("_NEED0","Aktif De�il");
define("_NEED1","Aktif");
define("_NEED2","�ye Olurken Sor");
define("_NEED3","�ye Olurken ZORUNLU");
define("_NAMECOMENT","*Sitenizde tek bir dil kullan�yorsan�z, <b>_</b> karakteriyle ba�lay�n");
define("_VALUECOMENT","**Liste olu�turmak isterseniz, kelimeleri birbirinden ay�rmak i�in <b>::</b> sembol�n� kullan�n");
define("_FIELDDEL","Sil");
define("_DELFIELD","Sil");
define("_CONFIRMDELLFIELD","Bu alan� silmek istedi�inizden emin misiniz:");
define("_YA_FILEDNEED1","L�tfen <b>");
define("_YA_FILEDNEED2","</b> alan�n� doldurunuz.");

define("_CREDITS","Krediler");
define("_YA_PUBLIC","Genel");
define("_YA_PRIVATE","�zel");
define("_YA_CODESIZE","G�venlik kodu uzunlu�u");
define("_YA_SUBAVT","Avatar� kaydet");
define("_SUPERUSER","S�per kullan�c�");
 
// NEW FROM CNB YOUR ACCOUNT 4.4 beta1
define("_COOKIECHECKNOTE","�erez konrol�n� (CookieCheck) etkinle�tir (beta)");
define("_COOKIECHECKNOTE2","Taray�c�n�n �erez kabul edip etmedi�ini kontrol et");
define("_YA_COOKIETEST","Taray�c� �erez Testi");
define("_YA_COOKIEOK","Tamam!");
define("_YA_COOKIEFAIL","BA�ARISIZ!");
define("_YA_COOKIENO","�erez fonksiyonlar� kapal� g�r�n�yor.<br>L�tfen taray�c� ayarlar�n�z� de�i�tirin!");
define("_YA_COOKIEYES","Taray�c�n�z �erez testini sorunsuz olarak ge�ti!");

define("_YA_DELCOOKIEINFO1","If you have problems with this website's authentiction (loggin in as a member), it is possible that your cookies have become corrupt. Here you can safely delete all cookies that are set by this website. Once you log in again, new cookies will be set automatically.");
define("_YA_CURRENTCOOKIE","Current Cookie Information:");
define("_YA_COOKIENOCUR1","No cookies are set by this website.");
define("_YA_COOKIENOCUR2","No cookies were set by this website.");
define("_YA_COOKIENAME","Cookie Name:");
define("_YA_COOKIEVAL","Cookie Value:");
define("_YA_COOKIESTAT","Cookie Status:");
define("_YA_COOKIEDEL1","The folowing cookies have been deleted:");
define("_YA_COOKIEDEL2","deleted");
define("_YA_COOKIEDELTHESE","Delete these Cookies");
define("_YA_COOKIEDELALL","Delete All Cookies");
define("_YA_COOKIESHOWALL","Show Current Cookies");
define("_LOGIN","Login");
// YA Private Messages Extended
define("_YAMESSAGES","Messages Summary");
define("_YAPM","Inbox");
define("_YAUNREAD","New");
define("_YAREAD","Read");
define("_YASAVED","Saved");
define("_YATT","Total");
define("_YAOUTBOX","Outbox");
/* YA COPPA HACK */
define("_ACTIVATECOPPA","COPPA Compliance Required");
define("_YACOPPA1","<h2>Children's Online Privacy Protection</h2>");
define("_YACOPPA2","You must be <b>13</b> or over, or have parental permission to register for membership here.<br><br>Are you age <b>13</b> or above?");
define("_YACOPPA3","<small>Please answer yes or no and click submit.</small>");
define("_YACOPPA4","<h1>We're Sorry!</h1> You must be <b>13</b> or have parents send a signed letter of consent to our site admin. Please contact our site admin for details by clicking <a href=\"./modules.php?name=Feedback\">here</a>.");
define("_YACOPPAFAX","Sorry no fax's accepted.");
/* YA TOS HACK */
define("_ACTIVATETOS","Must Agree to Terms of Service");
define("_YATOS1","Terms of Service");
define("_YATOS2","Our Terms of Service will be soon be published here.");
define("_YATOS3","I have read and agree to abide by these Terms.");
define("_YATOS4","New members must agree to our Terms of Service.");

// NEW FROM CNB YOUR ACCOUNT 4.4 beta2
define("_YACONFIGSAVED"," Configuration Saved.");
define("_DOUBLECHECKEMAIL","Doublecheck email at registration");
define("_DOUBLECHECKEMAILNOTE","Let users input their email adres twice");
define("_ACTIVATECOPPANOTE","Users have to be 13 years or older");
define("_COOKIECONFIG","Cookie Configuration");
define("_COOKIECLEANERNOTE1","Activate the CookieCleaner");
define("_COOKIECLEANERNOTE2","Shows the option to delete all cookies set by this site");

define("_YATOS5","All members need to accept these Terms of Service [TOS].");
define("_ACTIVATETOSNOTE","Force new members to agree when they register:");
define("_ACTIVATETOSALL","Show TOS to members as well:");
define("_ACTIVATETOSALLNOTE","If Terms of Service are new or changed");
define("_YATOSINTRO1","Hello! Our Terms of Service have been changed.<br>To continue your membership we enquire you to agree with our Terms of Service (TOS). If you choose not to agree your account will not expire but you will not be able to login until you do.");
define("_YATOSINTRO2","Hello! Welcome as a new member of this website!<br>To apply for a membership you will have to agree with our Terms of Service.");

define("_YA_CONTINUE","Continue");
define("_YA_GOBACK","Go Back");

define("_YA_APPROVE","Approve");
define("_YA_APPROVE2","Approved");
define("_YA_APPROVEUSER","Approve User");
define("_YA_APPROVED","You have approved the membership of:");
define("_YA_APPROVENOTE","'Approve' will aprove the membership and send the activation email");
define("_YA_ACTIVATE","Activate");
define("_YA_ACTIVATEUSER","Activate User");
define("_YA_ACTIVATED","The user account is activated. The user will be able to login now");
define("_YA_ACTIVATENOTE","'Activate' will activate the membership immediately and send a welcome email");
define("_YA_ACTIVATEWARN1","Warning! If you activate this user now, the emailadres will not be verified to be valid");
define("_YA_ACTIVATEWARN2","We recommend you to 'approve' this user instead. An activation email will then be send to the users email adres");
define("_YA_SENDMAIL","An activation email has been sent to the users email adres");

define("_YA_REALNAMENOTE", "Please enter both your first and last name");
define("_YA_NOREALNAME","You forgot to enter your realname (both first and last name)");

define("_CHANGEMAIL1","You or someone else has used your account to change your registered email address from");
define("_CHANGEMAIL2"," to ");
define("_CHANGEMAIL3"," in site ");
define("_CHANGEMAILFIN","To confirm the email change process you should visit the following link:");
define("_CHANGEMAILSUB","Change Email Account");
define("_CHANGEMAILTITLE","Change mail");
define("_CHANGEMAILOK","Your registered email address has been changed.");
define("_CHANGEMAILNOT","ERROR: Something wrong has happened in the changing pf your registered email!!<br> Try Again.");
define("_CHANGEMAILNOTUSER","ERROR: You need to login to confirm your new email address.");
define("_YA_UPDATEYOUTABLE","<b>ERROR: YOU NEED TO UPDATE YOU DATA BASE TABLE NOW!!</b><br>Run cnbya.php from the root of your phpnuke installation, update the database tables, and delete the file afterwards!<br>The version of the module is ");
define("_YA_UPDATEYOUTABLE1"," and the version of your data base table is ");

?>