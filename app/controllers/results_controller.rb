class ResultsController < ApplicationController
    helper_method :generateBarcode
    helper_method :base64_image
    require 'rmagick'
    require 'chunky_png'
    require 'barby/barcode/code_128'
    require 'barby/outputter/rmagick_outputter'
    require 'barby'

    def index
        @partial = nil
        @sorted = []
        @partial = params['sku'] unless params['sku'].nil?
        @sorted = Sku.all.order(:created_at)

        unless @partial.nil?
            @sorted = Sku.where('sku LIKE ?', "#{@partial}%")

            if @sorted.count == 0 && Sku.where('model LIKE ?', "#{@partial}%").count > 0
                @sorted = Sku.where('model LIKE ?', "#{@partial}%")
            elsif @sorted.count == 0
                @sorted = Sku.where('brand LIKE ?', "#{@partial}%")
            else
              @sorted = 0

            end


              @sorted = Sku.all.order(:created_at) if @partial == ''
      end


        @skus = []
        @sorted.all.each do |sku|
            @skuID = sku.sku
            @json = JSON.parse(sku.json)
            @json['Brand'] = 'Not specified' if @json['Brand'] == ''
            @json['Model'] = 'Not specified' if @json['Model'] == ''
            @json['Tested'] = 'Not specified' if sku['created_at'] == ''
            @skus.push(@skuID => @json)
        end
    end

    def base64_image(image_data)
        "<img src='data:image/png;base64,#{image_data}' />".html_safe
    end

    def generateBarcode(sku)
        barcode = Barby::Code128B.new(sku)
        @img = barcode.to_image
        @img.format = 'png'
        Base64.encode64(@img.to_blob).delete("\n")
    end
end
