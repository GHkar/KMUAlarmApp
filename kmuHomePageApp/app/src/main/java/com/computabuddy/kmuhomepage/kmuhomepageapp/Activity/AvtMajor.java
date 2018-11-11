//------------------------------------------------------------------------------------------------//
// Filename     : AvtMenu.java
// Created date : 2018.11.1
// Author       : HS.Go
//
// Copyright(c) computabuddy. All rights reserved.
//------------------------------------------------------------------------------------------------//
package com.computabuddy.kmuhomepage.kmuhomepageapp;
//------------------------------------------------------------------------------------------------//
//
//------------------------------------------------------------------------------------------------//
import android.content.Intent;
import android.os.Bundle;
import android.support.design.widget.FloatingActionButton;
import android.support.design.widget.Snackbar;
import android.view.View;
import android.support.design.widget.NavigationView;
import android.support.v4.view.GravityCompat;
import android.support.v4.widget.DrawerLayout;
import android.support.v7.app.ActionBarDrawerToggle;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.widget.Button;
import android.widget.Switch;

//------------------------------------------------------------------------------------------------//
//
//------------------------------------------------------------------------------------------------//
public class AvtMajor extends AppCompatActivity
        implements NavigationView.OnNavigationItemSelectedListener, View.OnClickListener
{
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    @Override
    protected void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.avt_major);
        Toolbar toolbar = (Toolbar) findViewById(R.id.toolbar);
        setSupportActionBar(toolbar);
        setTitle("학과"); // 액션바에 타이틀 이름 셋팅.

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        ActionBarDrawerToggle toggle = new ActionBarDrawerToggle(
                this, drawer, toolbar, R.string.navigation_drawer_open, R.string.navigation_drawer_close);
        drawer.addDrawerListener(toggle);
        toggle.syncState();

        NavigationView navigationView = (NavigationView) findViewById(R.id.nav_view);
        navigationView.setNavigationItemSelectedListener(this);

        initControl();

    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    protected void initControl()
    {
        findViewById(R.id.btnMajor).setOnClickListener(this);
        findViewById(R.id.btnHome).setOnClickListener(this);
        findViewById(R.id.btnSchool).setOnClickListener(this);
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    @Override
    public void onClick(View view)
    {
        switch(view.getId()) // view가 부모클래스 -> button -> getId -> 버튼 Id를 가지고 올 수 있어.
        {
            case R.id.btnMajor:
            {
                Intent intent = new Intent(AvtMajor.this, AvtMenu.class);
                startActivity(intent);
                finish();
                break;
            }
            case R.id.btnHome:
            {
                Intent intent = new Intent(AvtMajor.this, AvtMenu.class);
                startActivity(intent);
                finish();
                break;
            }
            case R.id.btnSchool:
            {
                Intent intent = new Intent(AvtMajor.this, AvtMenu.class);
                startActivity(intent);
                finish();
                break;
            }

        }
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    @Override
    public void onBackPressed()
    {
        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        if (drawer.isDrawerOpen(GravityCompat.START))
            drawer.closeDrawer(GravityCompat.START);
        else
            super.onBackPressed();
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.avt_major, menu);
        return true;
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    @Override
    public boolean onOptionsItemSelected(MenuItem item)
    {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_settings)
            return true;

        return super.onOptionsItemSelected(item);
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    @SuppressWarnings("StatementWithEmptyBody")
    @Override
    public boolean onNavigationItemSelected(MenuItem item)
    {
        // Handle navigation view item clicks here.
        int id = item.getItemId();

        if (id == R.id.nav_camera)
        {

        }
        else if (id == R.id.nav_gallery)
        {

        }
        else if (id == R.id.nav_slideshow)
        {

        }
        else if (id == R.id.nav_manage)
        {

        }
        else if (id == R.id.nav_share)
        {

        }
        else if (id == R.id.nav_send)
        {

        }

        DrawerLayout drawer = (DrawerLayout) findViewById(R.id.drawer_layout);
        drawer.closeDrawer(GravityCompat.START);
        return true;
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
}
//------------------------------------------------------------------------------------------------//
//
//------------------------------------------------------------------------------------------------//