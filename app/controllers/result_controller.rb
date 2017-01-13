class ResultController < ApplicationController
    require 'rmagick'
    require 'chunky_png'
    require 'barby/barcode/code_128'
    require 'barby/outputter/rmagick_outputter'
    require 'barby'

    def load

        @barcodeImage = base64_image(barcode(params['sku']))
        @data = getData(params['sku'])

      end

    def base64_image(image_data)
        "<img src='data:image/png;base64,#{image_data}' />".html_safe
    end

    def barcode(sku)
        barcode = Barby::Code128B.new(sku)
        @img = barcode.to_image
        @img.format = 'png'
        Base64.encode64(@img.to_blob).delete("\n")
    end

    def getData(mainSku)
        if @sku = Sku.find_by_sku(mainSku)
            JSON.parse(@sku.json)
        else
            Sku.find_by_sku(mainSku)
            @error = 'Sorry, that SKU could not be found'
        end
    end
end
