# 3.0.0

## Changes

* Renamed namespace `Core23\DompdfBundle` to `Nucleos\DompdfBundle` after move to [@nucleos]

  Run

  ```
  $ composer remove core23/dompdf-bundle
  ```

  and

  ```
  $ composer require nucleos/dompdf-bundle
  ```

  to update.

  Run

  ```
  $ find . -type f -exec sed -i '.bak' 's/Core23\\DompdfBundle/Nucleos\\DompdfBundle/g' {} \;
  ```

  to replace occurrences of `Core23\DompdfBundle` with `Nucleos\DompdfBundle`.

  Run

  ```
  $ find -type f -name '*.bak' -delete
  ```

  to delete backup files created in the previous step.

# 2.6.0

## Changes

- Add missing strict file header @core23 (#48)
- Remove old symfony <4.2 code @core23 (#46)
- Removed explicit private visibility of services @core23 (#33)

## 🚀 Features

- Add support for symfony 5 @core23 (#40)
- Use symfony contracts @core23 (#27)
