[BITS 16]

    ;Sends us to the end of the memory
    ;causing reboot 
    db 0x0ea 
    dw 0x0000 
    dw 0xffff 
	
	ret