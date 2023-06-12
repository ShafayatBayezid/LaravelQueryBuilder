<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostController extends Controller {
    function assignments() {
        // Q2
        $posts = DB::table( 'posts' )
            ->select( 'excerpt', 'description' )
            ->get();

        //Q4
        $posts = DB::table( 'posts' )
            ->where( 'id', '==', '2' )
            ->select( 'description' )
            ->first();

        //Q5
        $posts = DB::table( 'posts' )
            ->where( 'id', '==', '2' )
            ->pluck( 'description' );

        //Q7
        $posts = DB::table( 'posts' )
            ->select( 'title' )
            ->get();

        //Q11
        $posts = DB::table( 'users' )->count();
        $posts = DB::table( 'posts' )->sum( 'min_to_read' );
        $posts = DB::table( 'posts' )->avg( 'min_to_read' );
        $posts = DB::table( 'posts' )->max( 'min_to_read' );
        $posts = DB::table( 'posts' )->min( 'min_to_read' );

        //Q13
        $hasActiveUsers = DB::table( 'users' )
            ->where( 'status', 'active' )
            ->exists();

        if ( $hasActiveUsers ) {
            echo "There are active users.";
        } else {
            echo "No active users found.";
        }

        $noInactiveUsers = DB::table( 'users' )
            ->where( 'status', 'inactive' )
            ->doesntExist();

        if ( $noInactiveUsers ) {
            echo "There are no inactive users.";
        } else {
            echo "Inactive users found.";
        }

        //Q14
        $posts = DB::table( 'posts' )
            ->whereBetween( 'min_to_read', [1, 5] )
            ->get();

        print_r( $posts );

        //Q15
        $affectedRows = DB::table( 'posts' )
            ->where( 'id', 3 )
            ->increment( 'min_to_read', 1 );

        echo "Number of affected rows: " . $affectedRows;

    }

    function insertNew( Request $request ) {
        //Q8
        if ( $request->validate() ) {
            $posts = DB::table( 'posts' )
                ->insert( [
                    'title'        => $request->input( 'title' ),
                    'slug'         => $request->input( 'slug' ),
                    'excerpt'      => $request->input( 'excerpt' ),
                    'description'  => $request->input( 'description' ),
                    'is_published' => $request->input( 'is_published' ),
                    'min_to_read'  => $request->input( 'min_to_read' ),
                ] );
            if ( !$posts ) {
                $request->json( [
                    'success' => false,
                    'msg'     => 'Data not created',
                ] );
            } else {
                $request->json( [
                    'success' => true,
                    'msg'     => $posts,
                ] );
            }
        }

        // Q9
        $updatedRows = DB::table( 'posts' )
            ->where( 'id', 2 )
            ->update( ['excerpt' => 'Laravel 10', 'description' => 'Laravel 10'] );

        echo "Number of affected rows: " . $updatedRows;

        // Q10
        $deletedRows = DB::table( 'posts' )
            ->where( 'id', 3 )
            ->delete();

        echo "Number of deleteed rows: " . $deletedRows;

        //Q12
        $posts = DB::table( 'posts' )
            ->whereNot( 'is_published', '0' )
            ->get();

    }
}
