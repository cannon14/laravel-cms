fixMozillaZIndex=true; //Fixes Z-Index problem  with Mozilla browsers but causes odd scrolling problem, toggle to see if it helps
_menuCloseDelay=500;
_menuOpenDelay=150;
_subOffsetTop=0;
_subOffsetLeft=-0;




with(menuStyle=new mm_style()){
bordercolor="#999999";
borderstyle="solid";
borderwidth=1;
fontsize="100%";
fontstyle="normal";
headerbgcolor="#ffffff";
headercolor="#000000";
offbgcolor="#eeeeee";
offcolor="#000000";
onbgcolor="#2E7090";
oncolor="#ffffff";
outfilter="randomdissolve(duration=0.3)";
overfilter="Fade(duration=0.2);Alpha(opacity=90);Shadow(color=#777777', Direction=135, Strength=3)";
padding=4;
pagebgcolor="#82B6D7";
pagecolor="black";
separatorcolor="#2E7090";
separatorsize=1;
subimage="mil/arrow.gif";
subimagepadding=0;
}

with(milonic=new menuname("Websites")){
alwaysvisible=1;
left=10;
orientation="horizontal";
style=menuStyle;
top=0;

with(milonic=new menuname("Main Menu")){
alwaysvisible=1;
left=10;
orientation="horizontal";
style=menuStyle;
top=10;
aI("text=CS CMS;");
aI("showmenu=Manage;text=Manage;");
aI("showmenu=Tools;text=Tools;");
aI("showmenu=Edit;text=Edit;");
aI("showmenu=About;text=About;");
aI("text=Logout;url=index.php?mod=CMS_view_login&logout=1;")

}

with(milonic=new menuname("Manage")){
overflow="scroll";
style=menuStyle;
aI("text=Users;url=index.php?mod=CMS_view_users;");
aI("text=Sites;url=index.php?mod=CMS_view_sites;");
aI("text=Card Pages;url=index.php?mod=CMS_view_pages;");
aI("text=Page Components;url=index.php?mod=CMS_view_content;");
aI("text=Cards;showmenu=cards;");

}

with(milonic=new menuname("cards")){
overflow="scroll";
style=menuStyle;
aI("text=Cards;url=index.php?mod=CMS_view_cards;");
aI("text=Amenities;url=index.php?mod=CMS_view_amenities;");
}

with(milonic=new menuname("Tools")){
overflow="scroll";
style=menuStyle;
aI("text=Publish;showmenu=publish;");
aI("text=Export XML;url=index.php?mod=CMS_view_exportXml;");
aI("text=Export Rates;url=index.php?mod=CMS_view_ExportRates;");
aI("text=Upload Rates;url=index.php?mod=CMS_view_uploadRates;");
aI("text=Refactor Prime;url=index.php?mod=CMS_view_refactorPrime;");
aI("text=Diff;url=index.php?mod=CMS_view_diff;");
}


with(milonic=new menuname("publish")){
overflow="scroll";
style=menuStyle;
aI("text=Publish To CCBuild;url=index.php?mod=CMS_view_publishSite;");
aI("text=Publish To Production;url=index.php?mod=CMS_view_publishSiteToProd;");
}

with(milonic=new menuname("articles")){
overflow="scroll";
style=menuStyle;
aI("text=Article Pages;url=index.php;");
aI("text=Sub Headings;url=index.php;");
aI("text=Articles;url=index.php;");
}

with(milonic=new menuname("Edit")){
overflow="scroll";
style=menuStyle;
aI("text=Settings;url=index.php?mod=CMS_view_settings;");
aI("text=History;url=index.php?mod=CMS_view_history;");
}

with(milonic=new menuname("About")){
overflow="scroll";
style=menuStyle;
aI("text=About CMS;url=index.php?mod=CMS_view_about;");
}


}
drawMenus();

