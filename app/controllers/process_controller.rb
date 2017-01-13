class ProcessController < ApplicationController
    require 'aura-print'

    def submit
        sku = Sku.new
        jsonData = params
        jsonData.delete("commit")
        jsonData.delete("utf8")
        jsonData.delete("authenticity_token")
        jsonData.delete("action")
        jsonData.delete("controller")
        if jsonData["Condition"] != nil
          sku.sku = generate_sku(12)
          sku.json = jsonData.to_json
          sku.model = jsonData["Model"]
          sku.brand = jsonData["Brand"]

          require 'aura-print'
          @output = AuraPrint.barcodeWeb(jsonData['sku'], 'Tech')
          @sku = sku.sku
          sku.save!
          @blob = Base64.encode64(AuraPrint.systemPrintImage(@sku).to_blob).gsub(/\n/, "")
          @image = base64_image(@blob)
        else
          @error = "Missing values in field"
        end
    end
    def referer
      @env['HTTP_REFERER'] || '/'
    end
    def base64_image(image_data)
        "<img src='data:image/png;base64,#{image_data}' />".html_safe
    end

    def generate_sku(size = 6)
        charset = %w(2 3 4 6 7 9 A C D E F G H J K M N P Q R T V W X Y Z)
        (0...size).map { charset.to_a[rand(charset.size)] }.join
  end
end
