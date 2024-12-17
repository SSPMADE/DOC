var list = {

	"Java Script": {
		"JAVA SCRIPT EXAMPLES": [
			[ "Who is SSP", "Who-is-SSP" ],
			[ "Animated Search Form", "Animated-Search-Form" ],
			[ "Accordion", "Accordion" ],
			[ "Responsive Topnav", "Responsive-Topnav" ],
			[ "Horizontal Scrollable Menu", "Horizontal-Scrollable-Menu" ],
			[ "Fixed Top Menu", "Fixed-Top-Menu" ],
			[ "Fullscreen Overlay Nav", "Fullscreen-Overlay-Nav" ],
			[ "Animated Sidenav", "Animated-Sidenav" ],
			[ "Sidenav Push", "Sidenav-Push" ],
			[ "Sidenav", "Sidenav" ],
			[ "Modal Example", "Modal-Example" ],
			[ "Bottom Modal", "Bottom-Modal" ],
			[ "Animated Modal with Header and Footer", "Animated-Modal-with-Header-and-Footer" ],
			[ "Image Modal", "Image-Modal" ],
			[ "Image Gallery", "Image-Gallery" ],
			[ "Image Slide Show", "Image-Slide-Show" ],
			[ "Image-Slide-Show-auto", "Image-Slide-Show-auto" ],
			[ "Calculator", "Calculator" ],
			[ "simple calendar", "simple-calendar" ],
			[ "Popups", "Popups" ],
			[ "Notes", "Notes" ],
			[ "Tabs", "Tabs" ],
			[ "Todo list", "Todo-list" ],
			[ "Tool tips", "Tool-tips" ],
			[ "Toggle Switch", "Toggle-Switch" ],
			[ "Snackbar Toast", "Snackbar-Toast" ],
			[ "Progress bar", "Progress-bar" ],
			[ "JS Animation", "JS-Animation" ],
			[ "Alert Messages", "Alert-Messages" ],
			[ "Filter List", "Filter-List" ],
			[ "Popup Login", "Popup-Login" ],
			[ "Loaders1", "Loaders1" ],
			[ "Loaders2", "Loaders2" ],
			[ "Filter Table", "Filter-Table" ],
			[ "Responsive Pricing Tables", "Responsive-Pricing-Tables" ],
			[ "Web cam access", "Web-cam-access" ],
			[ "Draw a triangle", "draw-a-triangle" ],
			[ "Confirm dialog box", "Dialog-box-confirm" ],
			[ "Alart dialog box", "Dialog-box-alart" ],
			[ "Canvas Clock", "Canvas-Clock" ],
			[ "Canvas Snake Game", "Canvas-Snake-Game" ],
			[ "Canvas Game 1", "Canvas-Game-1" ],
			[ "Canvas Game 1 keyboad", "Canvas-Game-1-keyboad" ],
			[ "Game Pad", "Game-Pad" ],
			[ "Geolocation", "Geolocation" ],
			[ "Prompt dialog box", "Dialog-box-prompt" ],
			[ "Paralax", "Paralax" ],
			[ "Drag And Drop", "Drag-And-Drop" ],
			[ "Read xml online", "Read-xml-online" ],
			[ "Read json online", "Read-json-online" ],
			[ "Arrays", "Arrays" ],
			[ "Execute win Apps", "Execute-win-Apps"]

		],
		"3D in JAVA SCRIPT": [
			[ "3d using threejs", "3d-using-threejs" ],
			[ "3d using threejs ssp obj", "3d-using-threejs-ssp-obj"],
			[ "3d using threejs ssp obj mtl", "3d-using-threejs-ssp-obj-mtl" ],
			[ "3d using threejs loader json blender", "3d-using-threejs-loader-json-blender"],
			[ "3d tour", "3d-tour"]
		]
		}

};

var pages = {};

for ( var section in list ) {

	pages[ section ] = {};

	for ( var category in list[ section ] ) {

		pages[ section ][ category ] = {};

		for ( var i = 0; i < list[ section ][ category ].length; i ++ ) {

			var page = list[ section ][ category ][ i ];
			pages[ section ][ category ][ page[ 0 ] ] = page[ 1 ];

		}

	}

}
