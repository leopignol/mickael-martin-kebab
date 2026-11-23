.DEFAULT_TARGET := compress
.PHONY := compress

DIR_NAME  = S102_Liautaud_Pignol_Vinas
ARCHIVE_NAME = $(DIR_NAME).tar.xz

compress:
	@rm -rf $(ARCHIVE_NAME)
	@cp -r . ../$(DIR_NAME)
	@rm -rf ../$(DIR_NAME)/.??*
	@tar -cJf ../$(ARCHIVE_NAME) -C ../$(DIR_NAME) .
	@mv ../$(ARCHIVE_NAME) $(ARCHIVE_NAME)
	@rm -rf ../$(DIR_NAME)
	@file $(ARCHIVE_NAME)
	@du -h $(ARCHIVE_NAME)
