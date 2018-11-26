package com.computabuddy.kmuhomepage.kmuhomepageapp.Sqlite;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.SQLException;
import android.database.sqlite.SQLiteConstraintException;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteReadOnlyDatabaseException;

import com.computabuddy.kmuhomepage.kmuhomepageapp.Debug;

import java.io.File;

public class SqliteDb
{
    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
//    public static final boolean LOG_ENABLE = Debug.DEBUG;
//
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public static SqliteDb  instance = null;
//    private  static Context sContext = null;
//    protected SQLiteDatabase database = null;
//
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public static SqliteDb newInstance(Context context)
//    {
//        //Debug.log(LOG_ENABLE, "");
//        sContext = context;
//        instance = null;
//        return getInstance();
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public static SqliteDb getInstance()
//    {
//        if( instance == null )
//        {
//            Debug.log(LOG_ENABLE, "");
//            instance = new SqliteDb();
//        }
//
//        //if( database == null )
//        //    instance.openDatabase();
//
//        //Debug.log(LOG_ENABLE, "");
//        return instance;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public SqliteDb()
//    {
//        if( database == null )
//            openDatabase();
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public boolean openDatabase()
//    {
//        if( database == null )
//        {
//            File file = new File(sContext.getExternalFilesDir(null).getPath()
//                    + java.io.File.separator + DataManager.DBFILE_PREFIX + "Use.db");
//            String dbPath = file.getAbsolutePath();
//            Debug.log(LOG_ENABLE, "dbPath : " + dbPath);
//
//            File dbFile = new File(dbPath);
//
//            if(dbFile.exists() == false) return false;
//
//            database = SQLiteDatabase.openDatabase(dbPath, null, SQLiteDatabase.NO_LOCALIZED_COLLATORS);
//        }
//
//        if(database == null )
//            throw new SQLException();
//
//        return true;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public void closeDatabase()
//    {
//        database.close();
//        database = null;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public SQLiteDatabase getDatabase()
//    {
//        return database;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public boolean addProject()
//    {
//        if( database == null ) return false;
//
//        try
//        {
//            ContentValues row = new ContentValues();
//            row.put("id_prj", 1);
//            row.put("name", "A");
//            row.put("agency", "A");
//
//            database.insertOrThrow("tbl_", null, row);
//        }
//        catch(SQLiteConstraintException sqle)
//        {
//            Debug.log(LOG_ENABLE, "데이타 삽입 실패");
//            sqle.printStackTrace();
//
//            return false;
//        }
//        catch(SQLiteReadOnlyDatabaseException sqlRoe)
//        {
//            sqlRoe.printStackTrace();
//            closeDatabase();
//            openDatabase();
//        }
//
//        Debug.log(LOG_ENABLE, String.format("등록 성공"));
//
//        return true;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public int getUniversity(int id)
//    {
//        if( database == null ) return 0;
//
//        String query = "SELECT COUNT(*) ";
//        query += "FROM tbl_list ";
//        query += "WHERE id = %d ";
//        query += ";";
//        query = String.format(query, id);
//        Debug.log(LOG_ENABLE, query);
//
//        Cursor cursor = database.rawQuery(query, null);
//        cursor.moveToFirst();
//
//        if(cursor.getCount() > 0)
//        {
//
//            int rowCount = cursor.getInt(0);
//            Debug.log(LOG_ENABLE, "rowCount = " + rowCount);
//            return rowCount;
//        }
//
//        cursor.close();
//
//        return 0;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public int getNotice(int id)
//    {
//        if( database == null ) return 0;
//
//        String query = "SELECT COUNT(*) ";
//        query += "FROM tbl_list ";
//        query += "WHERE id = %d ";
//        query += ";";
//        query = String.format(query, id);
//        Debug.log(LOG_ENABLE, query);
//
//        Cursor cursor = database.rawQuery(query, null);
//        cursor.moveToFirst();
//
//        if(cursor.getCount() > 0)
//        {
//
//            int rowCount = cursor.getInt(0);
//            Debug.log(LOG_ENABLE, "rowCount = " + rowCount);
//            return rowCount;
//        }
//
//        cursor.close();
//
//        return 0;
//    }
//
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public int getList(int id)
//    {
//        if( database == null ) return 0;
//
//        String query = "SELECT COUNT(*) ";
//        query += "FROM tbl_list ";
//        query += "WHERE id = %d ";
//        query += ";";
//        query = String.format(query, id);
//        Debug.log(LOG_ENABLE, query);
//
//        Cursor cursor = database.rawQuery(query, null);
//        cursor.moveToFirst();
//
//        if(cursor.getCount() > 0)
//        {
//
//            int rowCount = cursor.getInt(0);
//            Debug.log(LOG_ENABLE, "rowCount = " + rowCount);
//            return rowCount;
//        }
//
//        cursor.close();
//
//        return 0;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public boolean updateUiversity(Uiversity university)
//    {
//        if( database == null ) return false;
//
//        String query = "SELECT COUNT(*) ";
//        query += "FROM tbl_list ";
//        query += "WHERE id = %d ";
//        query += ";";
//        query = String.format(query, university);
//        Debug.log(LOG_ENABLE, query);
//
//        Cursor cursor = database.rawQuery(query, null);
//        cursor.moveToFirst();
//
//        if(cursor.getCount() > 0)
//        {
//
//            int rowCount = cursor.getInt(0);
//            Debug.log(LOG_ENABLE, "rowCount = " + rowCount);
//            return rowCount; // 향후 다시 수정.
//        }
//
//        cursor.close();
//
//        return true;
//    }
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public boolean updateNotice(Notice notice)
//    {
//        if( database == null ) return false;
//
//        String query = "SELECT COUNT(*) ";
//        query += "FROM tbl_list ";
//        query += "WHERE id = %d ";
//        query += ";";
//        query = String.format(query, notice);
//        Debug.log(LOG_ENABLE, query);
//
//        Cursor cursor = database.rawQuery(query, null);
//        cursor.moveToFirst();
//
//        if(cursor.getCount() > 0)
//        {
//
//            int rowCount = cursor.getInt(0);
//            Debug.log(LOG_ENABLE, "rowCount = " + rowCount);
//            return rowCount; // 향후 다시 수정.
//        }
//
//        cursor.close();
//
//        return true;
//    }
//
//    //--------------------------------------------------------------------------------------------//
//    //
//    //--------------------------------------------------------------------------------------------//
//    public boolean updateList(Listaaa list)
//    {
//        if( database == null ) return false;
//
//        String query = "SELECT COUNT(*) ";
//        query += "FROM tbl_list ";
//        query += "WHERE id = %d ";
//        query += ";";
//        query = String.format(query, list);
//        Debug.log(LOG_ENABLE, query);
//
//        Cursor cursor = database.rawQuery(query, null);
//        cursor.moveToFirst();
//
//        if(cursor.getCount() > 0)
//        {
//
//            int rowCount = cursor.getInt(0);
//            Debug.log(LOG_ENABLE, "rowCount = " + rowCount);
//            return rowCount; // 향후 다시 수정.
//        }
//
//        cursor.close();
//
//        return true;
//    }

    //--------------------------------------------------------------------------------------------//
    //
    //--------------------------------------------------------------------------------------------//
}
