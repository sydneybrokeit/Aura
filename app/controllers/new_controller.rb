class NewController < ApplicationController
    require 'rmagick'
    require 'chunky_png'
    require 'barby/barcode/code_128'
    require 'barby/outputter/rmagick_outputter'
    require 'barby'

    def create
        @templates = JSON.parse(File.read('app/assets/templates/items.json'))

        unless params[:template].nil?
            session[:selected] = params[:template]
            @test = params[:template]
            @templateFileName = params[:template]
            @templateFileName.delete! '+'
            @templateParam = @templateFileName
            @masterTemplate = JSON.parse(File.read('app/assets/templates/master.json'))
            @templates["items"].each do |line|
                if JSON.parse(File.read('app/assets/templates/' + line[1]))['meta']['template_name'] == @templateParam
                    @template = JSON.parse(File.read('app/assets/templates/' + line[1]))
              end
            end
            fromTemplate(@template)

        end
    end

    def returnIfTooltip(name, template)
        if template && template['tooltips'] && template['tooltips'][name.downcase]

            @returnedTemplate.push('<p class="tooltiptext tooltip-right tooltip-extra">' + template['tooltips'][name.downcase] + '</p>')
        elsif template && template['tooltips'] && template['tooltips'][name]
            @returnedTemplate.push('<p class="tooltiptext tooltip-right tooltip-extra">' + template['tooltips'][name] + '</p>')
        end
    end

    def fromTemplate(_template)
        @returnedTemplate = []

        @masterTemplate['fields'].each do |field|
            ## Checks for the yield point in a template
            if field[0] == 'yield'
                @embeddedTemplate = _template
                unless @embeddedTemplate['fields'].nil?
                    @embeddedTemplate['fields'].each do |field|
                        ##
                        # field[0] will be the name of the object in the template, e.g. "Brand"
                        # field[1] will be the type of the object, e.g. "text"
                        ##

                        @returnedTemplate.push('<div class="tooltip form-option">')
                        @returnedTemplate.push('<label class="field-title">' + field[0] + ': </label>')
                        returnIfTooltip(field[0], @embeddedTemplate)
                        if field[1] == 'dropdown'
                            @returnedTemplate.push('<select name="' + field[0] + '" class="' + field[0].downcase + '">')
                            unless @embeddedTemplate['dropdowns'][field[0]].nil?
                                @embeddedTemplate['dropdowns'][field[0]].each do |dropdown|
                                    @returnedTemplate.push('<option>' + dropdown + '</option>')
                                end
                              end
                            @returnedTemplate.push('</select>')
                        else
                            @returnedTemplate.push('<input type="' + field[1] + '" name="' + field[0] + '" class="' + field[0].downcase + '">')
                        end
                        @returnedTemplate.push('</div>')
                    end
                end
                ## Checks for a brand field
            elsif field[0] == 'Brand' && _template['meta']['brand']
                @returnedTemplate.push('<div class="tooltip form-option">')
                @returnedTemplate.push('<label class="field-title">' + field[0] + ': </label>')
                returnIfTooltip(field[0], @embeddedTemplate)
                @returnedTemplate.push('<input type="' + field[1] + '" name="' + field[0] + '" class="' + field[0].downcase + '" value="' + _template['meta']['brand'] + '">')
                @returnedTemplate.push('</div>')

            ## Checks if it is a 'condition' field
            elsif field[1].respond_to?('each')
                @returnedTemplate.push('<div class="radio test123">')
                ##
                # field[0] will be the name of the object in the template, e.g. "Brand"
                # field[1] will be the type of the object, e.g. "text"
                ##

                ## Setting up variables that are useful for later goodness :D
                @selection = field[1]
                @title = field[0]
                @type = @selection['type']

                @returnedTemplate.push('<label class="field-title">' + @title + '</label>')
                @selection['options'].each do |field|
                    @returnedTemplate.push('<div class="tooltip radio-option">')
                    returnIfTooltip(field, @masterTemplate)

                    @returnedTemplate.push('<input type="' + @type + '" name="' + @title + '" class="' + field.downcase + '" value="' + field.downcase + '" id="' + field.downcase + '">' + field + '</input>')
                    # checks if we've got a notes field
                    if @selection['reason'].include? field
                        @returnedTemplate.push('<div class="reveal-if-active"><input type=text name="condition_reason" class="reason-field"  placeholder="Reason"></div>')
                    end
                    @returnedTemplate.push('</div>')
                end
                @returnedTemplate.push('</div>')

            else
                ## Fallback for semi-regular fields.
                @returnedTemplate.push('<div class="tooltip form-option">')
                @returnedTemplate.push('<label class="field-title">' + field[0] + ': </label>')
                returnIfTooltip(field[0], @masterTemplate)
                if field[0] == 'Notes'
                    @returnedTemplate.push('<textarea rows="2" cols="5" wrap="hard" type="' + field[0].downcase + '" name="' + field[0] + '" class="' + field[0].downcase + '"></textarea>')
                else
                    @returnedTemplate.push('<input type="' + field[1] + '" name="' + field[0] + '" class="' + field[0].downcase + '">')
                end
                @returnedTemplate.push('</div>')
          end
        end
    end
end
