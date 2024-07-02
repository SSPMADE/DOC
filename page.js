var onDocumentLoad = function ( event ) {
	var path;
	var pathname = window.location.pathname;
	var section = /\/(manual|api)\//.exec( pathname )[ 1 ].toString().split( '.html' )[ 0 ];
	var name = /[\-A-z0-9]+\.html/.exec( pathname ).toString().split( '.html' )[ 0 ];

	if ( section == 'manual' ) {
		name = name.replace( /\-/g, ' ' );
		path = pathname.replace( /\ /g, '-' );
		path = /\/manual\/[-A-z0-9\/]+/.exec( path ).toString().substr( 8 );
	} else {
		path = /\/api\/[A-z0-9\/]+/.exec( pathname ).toString().substr( 5 );
	}


//*Replased by ssptitle variable below*
//***********************
	//var text = document.body.innerHTML;
	//text = text.replace( /\[name\]/gi, name );
	//text = text.replace( /\[path\]/gi, path );
	//document.body.innerHTML = text;
//***********************
	
//*The ssptitle variable*
//***********************
var ssptitle = document.querySelector("h1");
if( ssptitle.innerHTML = "[name]" ){
    ssptitle.innerHTML = name;
}
//***********************


	// End of onDocumentLoad function
};

document.addEventListener( 'DOMContentLoaded', onDocumentLoad, false );
