package com.computabuddy.kmuhomepage.kmuhomepageapp;
//------------------------------------------------------------------------------------------------//
//
//------------------------------------------------------------------------------------------------//
import android.util.Log;

import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.Locale;
//------------------------------------------------------------------------------------------------//
//
//------------------------------------------------------------------------------------------------//
public class Debug
{
    // TODO : 앱 배포시 false
    public final static boolean DEBUG = true;

    public final static int LOG_EXCEPTION   = 1;
    public final static int LOG_ERROR       = 1 + LOG_EXCEPTION;
    public final static int LOG_WARNING     = 1 + LOG_ERROR;
    public final static int LOG_INFO        = 1 + LOG_WARNING;
    public final static int LOG_DEBUG       = 1 + LOG_INFO;

    private final static int LOG_LEVEL = LOG_DEBUG;

    private final static String TAG = "NeoMesh";

    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    public static void log(String message)
    {
        if (DEBUG)
        {
            String fullClassName = Thread.currentThread().getStackTrace()[3].getClassName();
            String className = fullClassName.substring(fullClassName.lastIndexOf(".") + 1);
            String methodName = Thread.currentThread().getStackTrace()[3].getMethodName();
            int lineNumber = Thread.currentThread().getStackTrace()[3].getLineNumber();

            Log.e(TAG, "[" + getTimeWithMilliSec() + "] " + className + "." + methodName + "():" + lineNumber + ", " + message);
        }
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    public static void log(boolean logEnable, String message)
    {
        if (DEBUG && logEnable)
        {
            String fullClassName = Thread.currentThread().getStackTrace()[3].getClassName();
            String className = fullClassName.substring(fullClassName.lastIndexOf(".") + 1);
            String methodName = Thread.currentThread().getStackTrace()[3].getMethodName();
            int lineNumber = Thread.currentThread().getStackTrace()[3].getLineNumber();

            Log.e(TAG, "[" + getTimeWithMilliSec() + "] " + className + "." + methodName + "():" + lineNumber + ", " + message);
        }
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    public static void log(int logLevel, String message)
    {
        if(LOG_LEVEL >= logLevel)
        {
            String fullClassName = Thread.currentThread().getStackTrace()[3].getClassName();
            String className = fullClassName.substring(fullClassName.lastIndexOf(".") + 1);
            String methodName = Thread.currentThread().getStackTrace()[3].getMethodName();
            int lineNumber = Thread.currentThread().getStackTrace()[3].getLineNumber();

            Log.e(TAG, "[" + getTimeWithMilliSec() + "] " + className + "." + methodName + "():" + lineNumber + ", " + message);
        }
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    public static void log(String tag, String message)
    {
        if (DEBUG)
        {
            String fullClassName = Thread.currentThread().getStackTrace()[3].getClassName();
            String className = fullClassName.substring(fullClassName.lastIndexOf(".") + 1);
            String methodName = Thread.currentThread().getStackTrace()[3].getMethodName();
            int lineNumber = Thread.currentThread().getStackTrace()[3].getLineNumber();

            Log.e(tag, "[" + getTimeWithMilliSec() + "] " + className + "." + methodName + "():" + lineNumber + ", " + message);
        }
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    public static void logHex(byte[] message)
    {
        if (DEBUG)
        {
            String fullClassName = Thread.currentThread().getStackTrace()[3].getClassName();
            String className = fullClassName.substring(fullClassName.lastIndexOf(".") + 1);
            String methodName = Thread.currentThread().getStackTrace()[3].getMethodName();
            int lineNumber = Thread.currentThread().getStackTrace()[3].getLineNumber();

            String strLog = String.format("LEN : %d, ", message.length);

            for( int idx = 0; idx < message.length; idx++ )
            {
                strLog += String.format("%02X ", (int)(message[idx] & 0xFF));
            }

            Log.e(TAG, "[" + getTimeWithMilliSec() + "] " + className + "." + methodName + "():" + lineNumber + ", " + strLog);
        }
    }
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
    public static String getTimeWithMilliSec()
    {
        SimpleDateFormat mSimpleDateFormat = new SimpleDateFormat("HH:mm:ss.SSS", Locale.KOREA);
        Date currentTime = new Date( );
        String mTime = mSimpleDateFormat.format ( currentTime );

        return mTime;
    }
}
//------------------------------------------------------------------------------------------------//
//
//------------------------------------------------------------------------------------------------//


