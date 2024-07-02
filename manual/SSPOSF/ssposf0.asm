; ==================================================================
; SSPOSF -- The SSPOSF kernel
; Copyright (C) 2017 SSPOSF Developer, SSP.
; This OS is built for a floppy disk.
; You can use rufus to export it to an sd card using dd.
; ==================================================================


	BITS 16

	%DEFINE SSPOSF_VER '001'	; OS version number
	%DEFINE SSPOSF_API_VER 16	; API version for programs to check


	; This is the location in RAM for kernel disk operations, 24K
	; after the point where the kernel has loaded; it's 8K in size,
	; because external programs load after it at the 32K point:

	disk_buffer	equ	24576


; ------------------------------------------------------------------
; OS CALL VECTORS -- Static locations for system call vectors
; Note: these cannot be moved, or it'll break the calls!

; The comments show exact locations of instructions in this section,
; and are used in apps/sspdev.asm so that an external program can
; use a SSPOSF system call without having to know its exact position
; in the kernel source code...

os_call_vectors:
	jmp os_main			; 0000h -- Called from bootloader
	jmp os_print_string		; 0003h
	jmp os_move_cursor		; 0006h
	jmp os_clear_screen		; 0009h
	jmp os_print_horiz_line		; 000Ch
	jmp os_print_newline		; 000Fh
	jmp os_wait_for_key		; 0012h
	jmp os_check_for_key		; 0015h
	jmp os_int_to_string		; 0018h
	jmp os_speaker_tone		; 001Bh
	jmp os_speaker_off		; 001Eh
	jmp os_load_file		; 0021h
	jmp os_pause			; 0024h
	jmp os_fatal_error		; 0027h
	jmp os_draw_background		; 002Ah
	jmp os_string_length		; 002Dh
	jmp os_string_uppercase		; 0030h
	jmp os_string_lowercase		; 0033h
	jmp os_input_string		; 0036h
	jmp os_string_copy		; 0039h
	jmp ssp001_dialog_box		; 003Ch			ssp001edit:was os_dialog_box
	jmp os_string_join		; 003Fh
	jmp os_get_file_list		; 0042h
	jmp os_string_compare		; 0045h
	jmp os_string_chomp		; 0048h
	jmp os_string_strip		; 004Bh
	jmp os_string_truncate		; 004Eh
	jmp os_bcd_to_int		; 0051h
	jmp os_get_time_string		; 0054h
	jmp os_get_api_version		; 0057h
	jmp os_file_selector		; 005Ah
	jmp os_get_date_string		; 005Dh
	jmp os_send_via_serial		; 0060h
	jmp os_get_via_serial		; 0063h
	jmp os_find_char_in_string	; 0066h
	jmp os_get_cursor_pos		; 0069h
	jmp os_print_space		; 006Ch
	jmp os_dump_string		; 006Fh
	jmp os_print_digit		; 0072h
	jmp os_print_1hex		; 0075h
	jmp os_print_2hex		; 0078h
	jmp os_print_4hex		; 007Bh
	jmp os_long_int_to_string	; 007Eh
	jmp os_long_int_negate		; 0081h
	jmp os_set_time_fmt		; 0084h
	jmp os_set_date_fmt		; 0087h
	jmp os_show_cursor		; 008Ah
	jmp os_hide_cursor		; 008Dh
	jmp os_dump_registers		; 0090h
	jmp os_string_strincmp		; 0093h
	jmp os_write_file		; 0096h
	jmp os_file_exists		; 0099h
	jmp os_create_file		; 009Ch
	jmp os_remove_file		; 009Fh
	jmp os_rename_file		; 00A2h
	jmp os_get_file_size		; 00A5h
	jmp os_input_dialog		; 00A8h
	jmp os_list_dialog		; 00ABh
	jmp os_string_reverse		; 00AEh
	jmp os_string_to_int		; 00B1h
	jmp os_draw_block		; 00B4h
	jmp os_get_random		; 00B7h
	jmp os_string_charchange	; 00BAh
	jmp os_serial_port_enable	; 00BDh
	jmp os_sint_to_string		; 00C0h
	jmp os_string_parse		; 00C3h
	jmp os_run_basic		; 00C6h
	jmp os_port_byte_out		; 00C9h
	jmp os_port_byte_in		; 00CCh
	jmp os_string_tokenize		; 00CFh


; ------------------------------------------------------------------
; START OF MAIN KERNEL CODE

os_main:
	cli				; Clear interrupts
	mov ax, 0
	mov ss, ax			; Set stack segment and pointer
	mov sp, 0FFFFh
	sti				; Restore interrupts

	cld				; The default direction for string operations
					; will be 'up' - incrementing address in RAM

	mov ax, 2000h		; Set all segments to match where kernel is loaded
	mov ds, ax			; After this, we don't need to bother with
	mov es, ax			; segments ever again, as SSPOSF and its programs
	mov fs, ax			; live entirely in 64K
	mov gs, ax

	cmp dl, 0
	je no_change
	mov [bootdev], dl		; Save boot device number
	push es
	mov ah, 8			; Get drive parameters
	int 13h
	pop es
	and cx, 3Fh			; Maximum sector number
	mov [SecsPerTrack], cx		; Sector numbers start at 1
	movzx dx, dh			; Maximum head number
	add dx, 1			; Head numbers start at 0 - add 1 for total
	mov [Sides], dx

no_change:
	mov ax, 1003h			; Set text output with certain attributes
	mov bx, 0			; to be bright, and not blinking
	int 10h

	call os_seed_random		; Seed random number generator


; Let's see if there's a file called SSPOSF1.BIN and execute
; it if so, run it.
	mov ax, ssposf1_bin_file_name
	call os_file_exists
;	jc no_ssposf1_bin			; Skip next three lines if SSPOSF1.BIN doesn't exist. SSP001
;	jc option_screen
	jc app_selector				;SSP001 edit, App now jumps to app selector and Skip next three lines

	mov cx, 32768				; Otherwise load the program into RAM...
	call os_load_file
	jmp execute_bin_program		; ...and move on to the executing part
;-----------------------------------------------------------


;	; Or perhaps there's an AUTORUN.SSP file?
;no_ssposf1_bin:
;	mov ax, autorun_bas_file_name
;	call os_file_exists
;	jc option_screen		; Skip next section if AUTORUN.SSP doesn't exist
;
;	mov cx, 32768			; Otherwise load the program into RAM
;	call os_load_file
;	call os_clear_screen
;	mov ax, 32768
;	call os_run_basic		; Run the kernel's BASIC interpreter
;
;	jmp app_selector		; And go to the app selector menu when BASIC ends


; GUI menu or command line interface
option_screen:
	mov ax, os_init_msg		; Set up the welcome screen
	mov bx, os_version_msg
	mov cx, 00001111b		; Colour: white on black  ssp001 edit
	;mov cx, 11001111b		; Colour:white and light red i think ssp001 edit
	;0100 red ssp001 edit
	;mov cx, 00001111b		; Colour: white on black ssp001 edit
	call os_draw_background

	mov ax, dialog_string_1		; Ask if user wants app selector or command-line
	mov bx, dialog_string_2
	mov cx, dialog_string_3
	mov dx, 1			; We want a two-option dialog box (OK or Cancel)
	call ssp001_environment_dialog_box
	cmp ax, 1			; If OK (option 0) chosen, start app selector
	jne near app_selector

	call os_clear_screen		; Otherwise clean screen and start the CLI
	call os_command_line
	jmp option_screen		; Offer GUI menu or command line choice after CLI has exited
	; Data for the above code...
	os_init_msg		db 'SSPOSF', 0
	os_version_msg		db 'Version ', SSPOSF_VER, 0
	dialog_string_1		db 'Wellcome :)', 0
	dialog_string_2		db 'Select an interface:, ', 0
	dialog_string_3		db 'GUI menu or command line.', 0
;------------------------------------------------------


app_selector:
	mov ax, os_init_msg		; Draw main screen layout
	mov bx, os_version_msg
	;mov cx, 10011111b		; Colour: white text on light blue
	mov cx, 00001111b		; white text on black ssp001
	call os_draw_background

	call os_app_selector		; Get user to select a app, and store
					; the resulting string location in AX
					; (other registers are undetermined)
	;SSP001 edit: os_app_selector was os_file_selector

	jc option_screen		; Return to the CLI/menu choice screen if Esc pressed

	mov si, ax			; Did the user try to run 'SSPOSF.BIN'?
	mov di, kern_file_name
	call os_string_compare
	jc no_kernel_execute		; Show an error message if so


	; Next, we need to check that the program we're attempting to run is
	; valid -- in other words, that it has a .BIN extension

	push si				; Save filename temporarily

	mov bx, si
	mov ax, si
	call os_string_length

	mov si, bx
	add si, ax			; SI now points to end of filename...

	dec si
	dec si
	dec si				; ...and now to start of extension!

	mov di, bin_ext
	mov cx, 3
	rep cmpsb			; Are final 3 chars 'BIN'?
	jne not_bin_extension		; If not, it might be a '.SSP'

	pop si				; Restore filename


	mov ax, si
	mov cx, 32768			; Where to load the program file
	call os_load_file		; Load filename pointed to by AX


execute_bin_program:
	call os_clear_screen		; Clear screen before running

	mov ax, 0			; Clear all registers
	mov bx, 0
	mov cx, 0
	mov dx, 0
	mov si, 0
	mov di, 0

	call 32768			; Call the external program code,
					; loaded at second 32K of segment
					; (program must end with 'ret')

	call os_clear_screen		; When finished, clear screen
	jmp app_selector		; and go back to the program list


no_kernel_execute:			; Warn about trying to executing kernel!
	mov ax, kerndlg_string_1
	mov bx, kerndlg_string_2
	mov cx, kerndlg_string_3
	mov dx, 0			; One button for dialog box
	call ssp001_dialog_box

	jmp app_selector		; Start over again...


not_bin_extension:
	pop si				; We pushed during the .BIN extension check

	push si				; Save it again in case of error...

	mov bx, si
	mov ax, si
	call os_string_length

	mov si, bx
	add si, ax			; SI now points to end of filename...

	dec si
	dec si
	dec si				; ...and now to start of extension!

	mov di, bas_ext
	mov cx, 3
	rep cmpsb			; Are final 3 chars 'BAS'?
	jne not_bas_extension		; If not, error out


	pop si

	mov ax, si
	mov cx, 32768			; Where to load the program file
	call os_load_file		; Load filename pointed to by AX

	call os_clear_screen		; Clear screen before running

	mov ax, 32768
	mov si, 0			; No params to pass
	call os_run_basic		; And run our BASIC interpreter on the code!

	mov si, basic_finished_msg
	call os_print_string
	call os_wait_for_key

	call os_clear_screen
	jmp app_selector		; and go back to the program list


not_bas_extension:
	pop si

	mov ax, ext_string_1
	mov bx, ext_string_2
	mov cx, 0
	mov dx, 0			; One button for dialog box
	call ssp001_dialog_box

	jmp app_selector		; Start over again...


; And now data for the above code...
	kern_file_name		db 'SSPOSF.BIN', 0

	ssposf1_bin_file_name	db 'SSPOSF1.BIN', 0
	autorun_bas_file_name	db 'AUTORUN.SSP', 0

	bin_ext 	db 'BIN'
	bas_ext 	db 'SSP'

	kerndlg_string_1	db 'NO!', 0
	kerndlg_string_2	db 'ssposf.bin is the core of SSPOSF, and', 0
	kerndlg_string_3	db 'is not a normal program.', 0

	ext_string_1		db 'You can only execute', 0
	ext_string_2		db ' .BIN or .SSP programs.', 0

	basic_finished_msg	db '>>> SSP program finished -- press a key', 0
; ------------------------------------------------------------------

; SYSTEM VARIABLES -- Settings for programs and system calls
	; Time and date formatting
	fmt_12_24	db 0		; Non-zero = 24-hr format
	fmt_date	db 0, '/'	; 0, 1, 2 = M/D/Y, D/M/Y or Y/M/D
					; Bit 7 = use name for months
					; If bit 7 = 0, second byte = separator character
; ------------------------------------------------------------------

; FEATURES -- Code to pull into the kernel


	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/cli.asm"
 	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/disk.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/keyboard.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/math.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/misc.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/ports.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/screen.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/sound.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/string.asm"
	%INCLUDE "SSPOSI/2Sources/SSPOSFloppy/ssposf0features/basic.asm"


; ==================================================================
; END OF KERNEL
; ==================================================================

