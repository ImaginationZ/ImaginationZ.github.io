#include <time.h>
#include <stdio.h>

int main(){
    struct tm *ptr;
    time_t lt;
    char str[ 100 ];
    char ntime[ 100 ];
    lt = time(NULL);
    ptr = localtime( &lt );
    strftime( str,sizeof( str ), "%Y-%m-%d-", ptr );
    strftime( ntime,sizeof( ntime ), "%a %d %b %X %Y", ptr);
    printf( "Please enter a post title\ntitle: " );
    char title[ 80 ];
    gets(title);
    int i=0;
    while( str[ i ] ) ++i;
    int j=0;
    do{
        str[ i ] = title[ j ];
        str[ i+1 ] = 0;
        if( str[ i ] == ' ' ) str[ i ] = '-';
        ++j;
        ++i;
    }while( title[ j ] );
    str[ i ] = '.';
    ++i;
    str[ i ] = 'm';
    ++i;
    str[ i ] = 'd';
    ++i;
    str[ i ] = 0;
    FILE *post;
    if( ( post = fopen( str, "at+" ) ) == NULL ){
        printf( "cannot open this file!" );
        exit(1);
    }
    fputs( "---\n",post );
    fputs( "layout: post\n",post );
    fputs( "title: ",post );
    fputs( title, post );
    fputs( "\ndate: ",post );
    fputs( ntime, post );
    fputs( "\nbyline:",post );
    fputs( "\npic:",post );
    fputs( "\n---\n",post );
    exit(0);
}
