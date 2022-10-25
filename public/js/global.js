$( document ).ready(function() 
{
	if( $('.form-verify') )
	{
		$('.form-verify').click(function(evt) {

			let message = $(this).attr('data-message');

			if(message == null) 
				message = 'Are you sure you want to continue this proccess , irreversible process ';


			if(!confirm(message))
				evt.preventDefault();
		});
	}


	if( $('.copy-to-clip-board') )
	{

		$('.copy-to-clip-board').click( function() {
			let clip_board_value = $(this).data('copy');

			console.log(clip_board_value);
			alert("Copied to Clipboard");
			copyStringToClipBoard(clip_board_value);
		});
		
	}

	if( $('.flash-alert') )
	{
		setTimeout( function()
		{
			$('.flash-alert').hide();
		} , 4000);
	}

	function copyStringToClipBoard(text)
	{
		var $temp = $("<input>");

		$("body").append($temp);

		$temp.val(text).select();

		document.execCommand("copy");

		$temp.remove();
	}
	function copyToClipboard(element) 
	{
		var $temp = $("<input>");

		$("body").append($temp);

		$temp.val($(element).text()).select();
		document.execCommand("copy");
		$temp.remove();
	}
	
});



function createPin(text) {
	var svg = '<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M12 10c-1.104 0-2-.896-2-2s.896-2 2-2 2 .896 2 2-.896 2-2 2m0-5c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3m-7 2.602c0-3.517 3.271-6.602 7-6.602s7 3.085 7 6.602c0 3.455-2.563 7.543-7 14.527-4.489-7.073-7-11.072-7-14.527m7-7.602c-4.198 0-8 3.403-8 7.602 0 4.198 3.469 9.21 8 16.398 4.531-7.188 8-12.2 8-16.398 0-4.199-3.801-7.602-8-7.602"/></svg>'; // Imagine there's SVG here.
	return svg.replace('sample-text', text);
}