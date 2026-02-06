# Magento 2 Admin Log Viewer

A lightweight and efficient Magento 2 extension that allows store administrators to view and manage system log files (var/log) 
directly from the Magento Admin Panel. 
This tool eliminates the need for repeated SSH or FTP access just to check error logs.

## Features
- **Centralized Log Grid:** View all available log files in a clean UI component grid with file names and sizes.**
- **Integrated Log Viewer:**	View the last 'N' lines of any log file in a dedicated terminal-style interface within the Admin Panel.
- **Flexible System Configuration::**	
    - **Enable/Disable:** Fully toggle the module on or off from the configuration.
    - **Custom Line Count:** Configure exactly how many lines (e.g., 50, 100, 500) to display per view.
    - **Log Selection (Multiselect)::** A user-friendly multiselect dropdown to choose which specific log files are allowed to be displayed in the grid.
    - **Access Control & Security:**
        - Menu items automatically hide when the module is disabled.
        - Direct URL access is blocked with a custom notification message if the module is inactive.
    - **Performance:** Uses memory-efficient file reading (array slicing) to handle large log files without crashing the server.
## Installation:
-  **Upload Files:** Create the directory app/code/Pankaj/LogViewer and upload the module files into it.
-  **Enable the Module:** Run the following commands in your Magento root directory:
    -    ###### php bin/magento setup:upgrade
    -  ###### php bin/magento setup:di:compile
	- ######  php bin/magento setup:static-content:deploy -f
	- ###### php bin/magento cache:flush
## Configuration:
-    Navigate to **Stores > Settings > Configuration**
-    Go to **Log Viewer** > **Log Viewer Settings**.
-    Set **Enable Module to "Yes"**
-    Enter the **Number of Lines to Show (Default: 50)**
-    Select the **Allowed Log Files** from the multiselect list (e.g., exception.log, system.log).
-    Save Config and flush the cache.
## Usage:
- Go to **System > Log Viewer > View Logs**
- Browse the grid to find the log file you wish to inspect.
- Click the **View** action link to see the logs.
- The log content will be displayed in a secure, formatted viewer.