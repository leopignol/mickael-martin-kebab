.DEFAULT_TARGET := compress
.PHONY := compress

DIR_NAME  = MMK_Liautaud_Pignol_Vinas
ARCHIVE_NAME = $(DIR_NAME).tar.xz

compress:
	@rm -rf ~/Downloads/$(ARCHIVE_NAME)
	@cp -r . ~/$(DIR_NAME)
	@rm -rf ~/$(DIR_NAME)/.??*
	@tar -cJf ~/$(ARCHIVE_NAME) -C ~/$(DIR_NAME) .
	@mv ~/$(ARCHIVE_NAME) ~/Downloads/$(ARCHIVE_NAME)
	@rm -rf ~/$(DIR_NAME)
	@file ~/Downloads/$(ARCHIVE_NAME)
	@du -h ~/Downloads/$(ARCHIVE_NAME)
