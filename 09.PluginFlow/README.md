# Pankaj_PluginFlow

## Module Purpose
This module demonstrates **multiple Magento 2 plugins** applied on the same
method to clearly explain the **plugin execution flow**.

## What It Does
- Applies three plugins (Plugin A, Plugin B, Plugin C)
- All plugins use:
  - before
  - around
  - after methods
- Plugins are executed based on `sortOrder`

## Key Concepts Covered
- Multiple plugins on a single method
- sortOrder based execution
- before plugins (ascending order)
- around plugins (nested execution)
- after plugins (reverse order)
- Plugin chaining and interception flow

## Logging
- Log file: `var/log/plugin.log`
- Clearly shows execution sequence of Plugin A, B, and C

## Use Case
- Deep understanding of Magento plugin flow
- Debugging plugin conflicts
- Interview-level plugin explanation

## Compatibility
- Magento Open Source / Adobe Commerce
- Magento 2.x


